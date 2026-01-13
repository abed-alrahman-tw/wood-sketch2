<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Job;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function index(): View
    {
        $quoteRequests = QuoteRequest::query()
            ->with(['service', 'job.customer'])
            ->latest()
            ->paginate(20);

        return view('admin.quote-requests.index', compact('quoteRequests'));
    }

    public function show(QuoteRequest $quoteRequest): View
    {
        $quoteRequest->load(['service', 'job.customer', 'job.booking']);

        return view('admin.quote-requests.show', [
            'quoteRequest' => $quoteRequest,
        ]);
    }

    public function update(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,in_progress,closed'],
            'estimated_range_min' => ['nullable', 'numeric', 'min:0'],
            'estimated_range_max' => ['nullable', 'numeric', 'min:0', 'gte:estimated_range_min'],
            'admin_notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $quoteRequest->update($data);

        return redirect()
            ->route('admin.quote-requests.show', $quoteRequest)
            ->with('success', 'Quote request updated successfully.');
    }

    public function convert(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        if ($quoteRequest->job) {
            return redirect()
                ->route('admin.quote-requests.show', $quoteRequest)
                ->with('error', 'This quote has already been converted to a job.');
        }

        $quoteRequest->load('service');

        $data = $request->validate([
            'create_booking' => ['nullable', 'boolean'],
            'preferred_date' => ['nullable', 'date'],
            'preferred_time_range' => ['nullable', 'string', 'max:255'],
            'address_text' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:50'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        if (($data['create_booking'] ?? false) === true) {
            $request->validate([
                'preferred_date' => ['required', 'date'],
                'preferred_time_range' => ['required', 'string', 'max:255'],
                'latitude' => ['required', 'numeric'],
                'longitude' => ['required', 'numeric'],
            ]);
        }

        $customer = Customer::query()
            ->when(
                $quoteRequest->email,
                fn ($query) => $query->where('email', $quoteRequest->email),
                fn ($query) => $query->where('phone', $quoteRequest->phone)
            )
            ->first();

        if (! $customer) {
            $customer = Customer::query()->create([
                'name' => $quoteRequest->full_name,
                'phone' => $quoteRequest->phone,
                'email' => $quoteRequest->email,
                'default_address_text' => $quoteRequest->address_text,
                'postcode' => $quoteRequest->postcode,
                'latitude' => $quoteRequest->latitude,
                'longitude' => $quoteRequest->longitude,
                'notes' => null,
            ]);
        } else {
            $customer->fill([
                'name' => $customer->name ?: $quoteRequest->full_name,
                'phone' => $customer->phone ?: $quoteRequest->phone,
                'email' => $customer->email ?: $quoteRequest->email,
                'default_address_text' => $customer->default_address_text ?: $quoteRequest->address_text,
                'postcode' => $customer->postcode ?: $quoteRequest->postcode,
                'latitude' => $customer->latitude ?: $quoteRequest->latitude,
                'longitude' => $customer->longitude ?: $quoteRequest->longitude,
            ]);
            $customer->save();
        }

        $booking = null;
        if (($data['create_booking'] ?? false) === true) {
            $booking = Booking::query()->create([
                'full_name' => $quoteRequest->full_name,
                'phone' => $quoteRequest->phone,
                'email' => $quoteRequest->email,
                'service_id' => $quoteRequest->service_id,
                'service_type' => $quoteRequest->service?->name,
                'preferred_date' => $data['preferred_date'],
                'preferred_time_range' => $data['preferred_time_range'],
                'message' => $quoteRequest->message,
                'address_text' => $data['address_text'] ?? $quoteRequest->address_text,
                'postcode' => $data['postcode'] ?? $quoteRequest->postcode,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'is_outside_service_area' => false,
                'status' => 'pending',
            ]);
        }

        $job = Job::query()->create([
            'customer_id' => $customer->id,
            'booking_id' => $booking?->id,
            'quote_request_id' => $quoteRequest->id,
            'status' => 'lead',
        ]);

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'Quote converted to a customer and job.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Models\BlockedTime;
use App\Models\Booking;
use App\Models\SiteSetting;
use App\Support\CalendarInvite;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with('service')
            ->latest()
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load('service');
        $settings = SiteSetting::query()->first();

        return view('admin.bookings.show', [
            'booking' => $booking,
            'settings' => $settings,
        ]);
    }

    public function update(UpdateBookingStatusRequest $request, Booking $booking): RedirectResponse
    {
        $data = $request->validated();
        $status = $data['status'];

        if (in_array($status, ['approved', 'rescheduled'], true)) {
            $request->validate([
                'approved_start_at' => ['required', 'date'],
                'approved_end_at' => ['required', 'date', 'after:approved_start_at'],
            ]);
        }

        $start = isset($data['approved_start_at']) ? Carbon::parse($data['approved_start_at']) : null;
        $end = isset($data['approved_end_at']) ? Carbon::parse($data['approved_end_at']) : null;

        if ($start && $end) {
            $overlap = Booking::query()
                ->where('id', '!=', $booking->id)
                ->where('status', 'approved')
                ->whereNotNull('approved_start_at')
                ->whereNotNull('approved_end_at')
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('approved_start_at', [$start, $end])
                        ->orWhereBetween('approved_end_at', [$start, $end])
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery->where('approved_start_at', '<', $start)
                                ->where('approved_end_at', '>', $end);
                        });
                })
                ->exists();

            if ($overlap) {
                return back()
                    ->withInput()
                    ->with('error', 'The approved time overlaps with another approved booking.');
            }

            $blockedOverlap = BlockedTime::query()
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start_at', [$start, $end])
                        ->orWhereBetween('end_at', [$start, $end])
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery->where('start_at', '<', $start)
                                ->where('end_at', '>', $end);
                        });
                })
                ->exists();

            if ($blockedOverlap) {
                return back()
                    ->withInput()
                    ->with('error', 'The approved time overlaps with a blocked time range.');
            }
        }

        $booking->fill([
            'status' => $status,
            'approved_start_at' => $start,
            'approved_end_at' => $end,
            'proposed_date' => $data['proposed_date'] ?? null,
            'proposed_time_range' => $data['proposed_time_range'] ?? null,
            'admin_notes' => $data['admin_notes'] ?? null,
        ]);

        if ($status === 'declined') {
            $booking->approved_start_at = null;
            $booking->approved_end_at = null;
        }

        $booking->save();

        $booking->load('service');
        $settings = SiteSetting::query()->first();
        $adminEmail = $settings?->email ?? config('mail.from.address');

        $mailPayload = [
            'booking' => $booking,
            'settings' => $settings,
        ];

        $ics = null;
        if ($status === 'approved' && $start && $end) {
            $ics = CalendarInvite::fromBooking($booking, $start, $end);
        }

        if ($adminEmail) {
            Mail::send('emails.booking-status-admin', $mailPayload, function ($message) use ($adminEmail, $ics, $booking) {
                $message->to($adminEmail)
                    ->subject('Booking '.$booking->id.' status updated');

                if ($ics) {
                    $message->attachData($ics, 'booking-'.$booking->id.'.ics', [
                        'mime' => 'text/calendar; charset=utf-8',
                    ]);
                }
            });
        }

        if ($booking->email) {
            Mail::send('emails.booking-status-customer', $mailPayload, function ($message) use ($booking, $ics) {
                $message->to($booking->email)
                    ->subject('Your booking request has been '.$booking->status);

                if ($ics) {
                    $message->attachData($ics, 'booking-'.$booking->id.'.ics', [
                        'mime' => 'text/calendar; charset=utf-8',
                    ]);
                }
            });
        }

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }
}

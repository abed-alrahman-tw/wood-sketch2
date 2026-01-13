<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    private const DEFAULT_CENTER_LAT = 50.887;
    private const DEFAULT_CENTER_LNG = -0.327;

    public function create()
    {
        $settings = SiteSetting::query()->first();
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => 'Book a Consultation | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Request a booking and share your project details with our woodworking team.',
        ]);

        return view('public.bookings.create', [
            'settings' => $settings,
            'services' => $services,
            'seo' => $seo,
            'defaultCenter' => [
                'lat' => self::DEFAULT_CENTER_LAT,
                'lng' => self::DEFAULT_CENTER_LNG,
            ],
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $settings = SiteSetting::query()->first();
        $radius = $settings?->service_radius_miles ?? 20;

        $data['is_outside_service_area'] = $this->isOutsideServiceArea(
            (float) $data['latitude'],
            (float) $data['longitude'],
            $radius
        );

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('bookings', 'public');
        }

        $booking = Booking::query()->create($data);
        $booking->load('service');

        $adminEmail = $settings?->email ?? config('mail.from.address');
        $mailPayload = [
            'booking' => $booking,
            'settings' => $settings,
        ];

        if ($adminEmail) {
            Mail::send('emails.booking-request-admin', $mailPayload, function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                    ->subject('New Booking Request');
            });
        }

        if ($booking->email) {
            Mail::send('emails.booking-request-customer', $mailPayload, function ($message) use ($booking) {
                $message->to($booking->email)
                    ->subject('We received your booking request');
            });
        }

        return redirect()
            ->route('bookings.create')
            ->with('status', 'Thanks for your booking request! We will be in touch soon.');
    }

    private function isOutsideServiceArea(float $latitude, float $longitude, float $radiusMiles): bool
    {
        $earthRadius = 3959; // miles
        $latFrom = deg2rad(self::DEFAULT_CENTER_LAT);
        $lonFrom = deg2rad(self::DEFAULT_CENTER_LNG);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        $distance = $angle * $earthRadius;

        return $distance > $radiusMiles;
    }
}

<?php

namespace App\Support;

use App\Models\Booking;
use Carbon\CarbonInterface;

class CalendarInvite
{
    public static function fromBooking(Booking $booking, CarbonInterface $start, CarbonInterface $end): string
    {
        $uid = $booking->id.'@'.parse_url(config('app.url'), PHP_URL_HOST);
        $dtStamp = now()->utc()->format('Ymd\THis\Z');
        $dtStart = $start->copy()->utc()->format('Ymd\THis\Z');
        $dtEnd = $end->copy()->utc()->format('Ymd\THis\Z');
        $summary = 'Booking - '.$booking->full_name;
        $location = trim(($booking->address_text ?? '').' '.($booking->postcode ?? ''));
        $description = 'Approved booking for '.$booking->full_name.
            ($booking->service?->name ? ' ('.$booking->service->name.')' : '').'.';

        return implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//WoodSketch//Booking//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:REQUEST',
            'BEGIN:VEVENT',
            'UID:'.$uid,
            'DTSTAMP:'.$dtStamp,
            'DTSTART:'.$dtStart,
            'DTEND:'.$dtEnd,
            'SUMMARY:'.self::escapeText($summary),
            'DESCRIPTION:'.self::escapeText($description),
            $location ? 'LOCATION:'.self::escapeText($location) : null,
            'END:VEVENT',
            'END:VCALENDAR',
        ]);
    }

    private static function escapeText(string $value): string
    {
        return str_replace([
            "\\",
            ",",
            ";",
            "\n",
        ], [
            "\\\\",
            "\\,",
            "\\;",
            "\\n",
        ], $value);
    }
}

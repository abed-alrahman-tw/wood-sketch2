<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:approved,declined,rescheduled'],
            'approved_start_at' => ['nullable', 'date'],
            'approved_end_at' => ['nullable', 'date', 'after:approved_start_at'],
            'proposed_date' => ['nullable', 'date'],
            'proposed_time_range' => ['nullable', 'string', 'max:255'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}

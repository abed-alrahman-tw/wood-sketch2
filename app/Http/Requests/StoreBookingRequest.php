<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'service_type' => ['nullable', 'string', 'max:255'],
            'preferred_date' => ['required', 'date'],
            'preferred_time_range' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'address_text' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ];
    }
}

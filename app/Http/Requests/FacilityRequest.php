<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // hanya user login boleh
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rooms' => 'nullable|array',
            'rooms.*' => 'exists:rooms,id',
            'capacity' => 'required|integer|min:0',
            'price_per_night' => 'required|numeric|min:0',

        ];
    }
}

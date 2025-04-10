<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'page' => 'required|string|max:255',
                'ref' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'browser' => 'nullable|string|max:255',
                'device' => 'nullable|string|max:255',
                'platform' => 'nullable|string|max:255',
                'ip_address' => 'nullable|string',
                'utm_term' => 'nullable|string|max:255',
                'utm_source' => 'nullable|string|max:255',
                'utm_campaign' => 'nullable|string|max:255',
                'utm_medium' => 'nullable|string|max:255',
                'utm_content' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric|string',
                'longitude' => 'nullable|numeric|string',
                'gender' => 'nullable|string|max:255',
                'age' => 'nullable|string|max:255',
        ];
    }
}

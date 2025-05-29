<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DmpOneSyncRequest extends FormRequest
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
            'phone' => 'nullable|string',
            'timestamp' => 'nullable|integer',
            'website' => 'nullable|string',
            'page' => 'nullable|url',
            'yid' => 'nullable|string',
            'email' => 'nullable|email',
            'vk' => 'nullable|string',
            'fb' => 'nullable|string',
            'insta' => 'nullable|string',
            'ok' => 'nullable|string',
            'utm_source' => 'nullable|string',
            'utm_medium' => 'nullable|string',
            'utm_campaign' => 'nullable|string',
            'utm_term' => 'nullable|string',
            'utm_content' => 'nullable|string',
            'referer' => 'nullable|url',
            'ip' => 'nullable|ip',
            'stock_key' => 'nullable|string',
            'interests' => 'nullable|array',
            'interests.*' => 'nullable|array',
        ];
    }
}

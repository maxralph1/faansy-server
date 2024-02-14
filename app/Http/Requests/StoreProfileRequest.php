<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'user_id' => 'required|unique:users|ulid',
            'address' => 'nullable|max:255',
            'bio' => 'nullable|max:255',
            'phone_number' => 'nullable|max:255',
            'website_url' => 'nullable|max:255',
            'twitter_account' => 'nullable|max:255',
            'google_account' => 'nullable|max:255',
            'language' => 'nullable|in:de,en-US,fr',
            'dark_mode' => 'nullable|boolean',
        ];
    }
}

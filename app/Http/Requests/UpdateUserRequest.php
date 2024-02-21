<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'role_id' => 'nullable|ulid',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|string',
            'user_image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'user_background_image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'show_activity_status' => 'nullable|boolean',
            'free_subscription' => 'nullable|boolean',
            'subscription_amount' => 'nullable|string',
            'show_subscription_offers' => 'nullable|string',
            'verified' => 'nullable|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'role_id' => 'required|ulid',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'user_image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'user_background_image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'show_activity_status' => 'required|boolean',
            'free_subscription' => 'nullable|boolean',
            'subscription_amount' => 'nullable|string',
            'show_subscription_offers' => 'required|string',
            'passport_image_url' => 'required|string',
            'verified' => 'required|string',
        ];
    }
}

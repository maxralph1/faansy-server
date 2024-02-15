<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
            // 'user_id' => 'required|ulid',
            'country' => 'nullable|string',
            'state_province' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'email' => 'nullable|email:rfc,dns',
            'card_number' => 'nullable|numeric',
            'name_on_card' => 'nullable|string',
            'expiration' => 'nullable|string',
            'cvc' => 'nullable|string',
            'legal_age' => 'nullable|boolean',
        ];
    }
}

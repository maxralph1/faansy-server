<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
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
            'country' => 'required|string',
            'state_province' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'card_number' => 'required|numeric',
            'name_on_card' => 'required|string',
            'expiration' => 'required|string',
            'cvc' => 'required|string',
            // 'legal_age' => 'required|boolean',
        ];
    }
}

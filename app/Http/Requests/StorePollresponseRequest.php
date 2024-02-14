<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollresponseRequest extends FormRequest
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
            'poll_id' => 'required|ulid',
            'polloption_id' => 'nullable|ulid',
            'user_id' => 'required|ulid',
            'text_response' => 'required|string',
        ];
    }
}

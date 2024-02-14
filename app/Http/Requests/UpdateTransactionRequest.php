<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
            'beneficiary_id' => 'required|ulid',
            'transactor_id' => 'required|ulid',
            'transaction_type' => 'nullable|in:pay_per_view,subscription,tip,stream_tips,commission,vat',
            'amount' => 'nullable|numeric',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
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
            'chat_id' => 'required|ulid',
            'body' => 'nullable|string',
            'pay_per_view' => 'nullable|boolean',
            'payperviewamount' => 'nullable|numeric',
            'image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'video_url' => 'nullable|mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime',
            'read' => 'nullable|string',
        ];
    }
}

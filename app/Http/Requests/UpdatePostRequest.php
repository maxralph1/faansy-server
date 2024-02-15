<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            // 'body' => 'nullable|string',
            'image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'video_url' => 'nullable|mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime',
            'pay_per_view' => 'nullable|boolean',
            'pay_per_view_amount' => 'nullable|boolean',
            'scheduled_live_time' => 'nullable|date_format',
            'repost' => 'nullable|boolean',
            'repost_original_id' => 'nullable|ulid',
            'repost_body' => 'nullable|string',
        ];
    }
}

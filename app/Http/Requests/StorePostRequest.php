<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'body' => 'required|string',
            'image_url' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'image_url_2' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'image_url_3' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'image_url_4' => 'nullable|mimes:jpg,jpeg,bmp,png',
            'video_url' => 'nullable|mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime',
            // 'video_url' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime|max:102400',
            'pay_per_view' => 'nullable|boolean',
            'payperviewamount' => 'nullable|numeric',
            'scheduled_live_time' => 'nullable|date_format:Y-m-d\\TH:i',
            // 'repost' => 'nullable|boolean',
            'repost_original_id' => 'nullable|ulid',
            'repost_body' => 'nullable|string',
        ];
    }
}

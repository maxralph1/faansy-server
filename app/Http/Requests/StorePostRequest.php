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
            // 'image_url' => [
            //     'nullable',
            //     File::image()
            //         // ->min(1024)
            //         // ->max(12 * 1024)
            //         ->min('1kb')
            //         ->max('10mb')
            // ],
            // 'video_url' => [
            //     'required',
            //     File::video()
            //         // ->min(1024)
            //         // ->max(12 * 1024)
            //         ->min('1kb')
            //         ->max('10mb')
            // ],
            // 'video_url' => [
            //     'nullable',
            //     File::types(['mp4', 'mpeg'])
            //         ->min(1024)
            //         ->max(12 * 1024),
            // ],
            // 'video_url' => 'nullable|file|mimetypes:video/mp4,gif',
            'video_url' => 'nullable|file|mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime',
            'pay_per_view' => 'nullable|boolean',
            'pay_per_view_amount' => 'nullable|numeric',
            'scheduled_live_time' => 'nullable|date_format',
            'repost' => 'nullable|boolean',
            'repost_original_id' => 'nullable|ulid',
            'repost_body' => 'nullable|string',
        ];
    }
}

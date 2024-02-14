<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamcommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'stream' => [
                'id' => $this->stream->id,
                'body' => $this->stream->body,
                'user' => [
                    'id' => $this->stream->user->id,
                    'username' => $this->stream->user->username,
                    'first_name' => $this->stream->user->first_name,
                    'last_name' => $this->stream->user->last_name,
                    'user_image_url' => $this->stream->user->user_image_url,
                    'verified' => $this->stream->user->verified,
                ],
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

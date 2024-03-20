<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostcommentResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'post' => [
                'id' => $this->post->id,
                'body' => $this->post->body,
                'user' => [
                    'id' => $this->post->user->id,
                    'username' => $this->post->user->username,
                    'first_name' => $this->post->user->first_name,
                    'last_name' => $this->post->user->last_name,
                    'user_image_url' => $this->post->user->user_image_url,
                    'verified' => $this->post->user->verified,
                ],
            ],
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

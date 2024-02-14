<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserlikeResource extends JsonResource
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
            'liked' => [
                'id' => $this->liked->id,
                'username' => $this->liked->username,
                'first_name' => $this->liked->first_name,
                'last_name' => $this->liked->last_name,
                'user_image_url' => $this->liked->user_image_url,
                'verified' => $this->liked->verified,
            ],
            'liker' => [
                'id' => $this->liker->id,
                'username' => $this->liker->username,
                'first_name' => $this->liker->first_name,
                'last_name' => $this->liker->last_name,
                'user_image_url' => $this->liker->user_image_url,
                'verified' => $this->liker->verified,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

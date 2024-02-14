<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'slug' => $this->slug,
            'participator_1' => [
                'id' => $this->participator_1->id,
                'username' => $this->participator_1->username,
                'first_name' => $this->participator_1->first_name,
                'last_name' => $this->participator_1->last_name,
                'user_image_url' => $this->participator_1->user_image_url,
                'verified' => $this->participator_1->verified,
            ],
            'participator_2' => [
                'id' => $this->participator_2->id,
                'username' => $this->participator_2->username,
                'first_name' => $this->participator_2->first_name,
                'last_name' => $this->participator_2->last_name,
                'user_image_url' => $this->participator_2->user_image_url,
                'verified' => $this->participator_2->verified,
            ],
            'messages' => MessageResource::collection($this->messages),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
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
            'blocker' => [
                'id' => $this->blocker->id,
                'username' => $this->blocker->username,
                'first_name' => $this->blocker->first_name,
                'last_name' => $this->blocker->last_name,
                'user_image_url' => $this->blocker->user_image_url,
                'verified' => $this->blocker->verified,
            ],
            'blocked' => [
                'id' => $this->blocked->id,
                'username' => $this->blocked->username,
                'first_name' => $this->blocked->first_name,
                'last_name' => $this->blocked->last_name,
                'user_image_url' => $this->blocked->user_image_url,
                'verified' => $this->blocked->verified,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

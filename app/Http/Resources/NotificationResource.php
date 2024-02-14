<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
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
            'notification_type' => $this->notification_type,
            'monies_if_any' => $this->monies_if_any,
            'reference_id_to_resource' => $this->reference_id_to_resource,
            'transactor' => [
                'id' => $this->transactor->id,
                'username' => $this->transactor->username,
                'first_name' => $this->transactor->first_name,
                'last_name' => $this->transactor->last_name,
                'user_image_url' => $this->transactor->user_image_url,
                'verified' => $this->transactor->verified,
            ],
            'read' => $this->read
        ];
    }
}

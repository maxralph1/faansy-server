<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'amount_paid' => $this->amount_paid,
            'subscribed' => [
                'id' => $this->subscribed->id,
                'username' => $this->subscribed->username,
                'first_name' => $this->subscribed->first_name,
                'last_name' => $this->subscribed->last_name,
                'user_image_url' => $this->subscribed?->user_image_url,
                'verified' => $this->subscribed?->verified,
                'last_seen' => $this->subscribed?->last_seen,
            ],
            'subscriber' => [
                'id' => $this->subscriber->id,
                'username' => $this->subscriber->username,
                'first_name' => $this->subscriber->first_name,
                'last_name' => $this->subscriber->last_name,
                'user_image_url' => $this->subscriber?->user_image_url,
                'verified' => $this->subscriber?->verified,
                'last_seen' => $this->subscriber?->last_seen,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

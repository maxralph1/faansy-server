<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'country' => $this->country,
            'state_province' => $this->state_province,
            'address' => $this->address,
            'city' => $this->city,
            'email' => $this->email,
            'card_number' => $this->card_number,
            'name_on_card' => $this->name_on_card,
            'expiration' => $this->expiration,
            'cvc' => $this->cvc,
            'legal_age' => $this->legal_age,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

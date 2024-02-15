<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletfundingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount_funded' => $this->amount_funded,
            'wallet' => [
                'id' => $this->wallet->id,
                'balance' => $this->wallet->balance,
                'total_inflow' => $this->wallet->total_inflow,
                'total_expenditure' => $this->wallet->total_expenditure,
            ],
            'card' => [
                'id' => $this->card->id,
                'country' => $this->card->country,
                'state_province' => $this->card->state_province,
                'address' => $this->card->address,
                'city' => $this->card->city,
                'email' => $this->card->email,
                'card_number' => $this->card->card_number,
                'name_on_card' => $this->card->name_on_card,
                'expiration' => $this->card->expiration,
                'cvc' => $this->card->cvc,
            ],
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

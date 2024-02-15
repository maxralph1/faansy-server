<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FundraisingResource extends JsonResource
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
            'wallet' => [
                'user' => [
                    'id' => $this->wallet->user->id,
                    'username' => $this->wallet->user->username,
                    'first_name' => $this->wallet->user->first_name,
                    'last_name' => $this->wallet->user->last_name,
                    'user_image_url' => $this->wallet->user->user_image_url,
                    'verified' => $this->wallet->user->verified,
                ],
                'id' => $this->wallet->id,
                'balance' => $this->wallet->balance,
                'total_inflow' => $this->wallet->total_inflow,
                'total_expenditure' => $this->wallet->total_expenditure,
            ],
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'amount_donated' => $this->amount_donated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

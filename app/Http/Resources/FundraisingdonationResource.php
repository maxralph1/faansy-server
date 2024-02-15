<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FundraisingdonationResource extends JsonResource
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
            'amount_donated' => $this->amount_donated,
            'fundraising' => [
                'id' => $this->id,
                'wallet' => [
                    'user' => [
                        'id' => $this->fundraising->wallet->user->id,
                        'username' => $this->fundraising->wallet->user->username,
                        'first_name' => $this->fundraising->wallet->user->first_name,
                        'last_name' => $this->fundraising->wallet->user->last_name,
                        'user_image_url' => $this->fundraising->wallet->user->user_image_url,
                        'verified' => $this->fundraising->wallet->user->verified,
                    ],
                    'id' => $this->fundraising->wallet->id,
                    'balance' => $this->fundraising->wallet->balance,
                    'total_inflow' => $this->fundraising->wallet->total_inflow,
                    'total_expenditure' => $this->fundraising->wallet->total_expenditure,
                ],
                'user' => [
                    'id' => $this->fundraising->user->id,
                    'username' => $this->fundraising->user->username,
                    'first_name' => $this->fundraising->user->first_name,
                    'last_name' => $this->fundraising->user->last_name,
                    'user_image_url' => $this->fundraising->user->user_image_url,
                    'verified' => $this->fundraising->user->verified,
                ],
                'amount_donated' => $this->fundraising->amount_donated,
                'created_at' => $this->fundraising->created_at,
                'updated_at' => $this->fundraising->updated_at,
                'deleted_at' => $this->fundraising->deleted_at,
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

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipResource extends JsonResource
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
            'amount' => $this->amount,
            'recipient' => [
                'id' => $this->recipient->id,
                'username' => $this->recipient->username,
                'first_name' => $this->recipient->first_name,
                'last_name' => $this->recipient->last_name,
                'user_image_url' => $this->recipient->user_image_url,
                'verified' => $this->recipient->verified,
            ],
            'donor' => [
                'id' => $this->donor->id,
                'username' => $this->donor->username,
                'first_name' => $this->donor->first_name,
                'last_name' => $this->donor->last_name,
                'user_image_url' => $this->donor->user_image_url,
                'verified' => $this->donor->verified,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

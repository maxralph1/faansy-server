<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'amount' => $this->amount / 100,
            'transaction_type' => $this->transaction_type,
            'reference_id_to_resource' => $this->reference_id_to_resource,
            'beneficiary' => [
                'id' => $this->beneficiary->id,
                'username' => $this->beneficiary->username,
                'first_name' => $this->beneficiary->first_name,
                'last_name' => $this->beneficiary->last_name,
                'user_image_url' => $this->beneficiary?->user_image_url,
                'verified' => $this->beneficiary?->verified,
                'last_seen' => $this->beneficiary?->last_seen,
            ],
            'transactor' => [
                'id' => $this->transactor->id,
                'username' => $this->transactor->username,
                'first_name' => $this->transactor->first_name,
                'last_name' => $this->transactor->last_name,
                'user_image_url' => $this->transactor?->user_image_url,
                'verified' => $this->transactor?->verified,
                'last_seen' => $this->transactor?->last_seen,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

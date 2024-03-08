<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserverificationResource extends JsonResource
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
            'verification_material_image_url' => $this->verification_material_image_url,
            'approved' => $this->approved,
            'approval_time' => $this->approval_time,
            'rejected' => $this->rejected,
            'reason_for_rejection' => $this->reason_for_rejection,
            'requester' => [
                'id' => $this->requester->id,
                'username' => $this->requester->username,
                'first_name' => $this->requester->first_name,
                'last_name' => $this->requester->last_name,
                'requester_image_url' => $this->requester->user_image_url,
                'verified' => $this->requester->verified,
            ],
            'approver' => [
                'id' => $this?->approver?->id,
                'username' => $this?->approver?->username,
                'first_name' => $this?->approver?->first_name,
                'last_name' => $this?->approver?->last_name,
                'approver_image_url' => $this?->approver?->user_image_url,
                'verified' => $this?->approver?->verified,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

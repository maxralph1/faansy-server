<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FanactivityResource extends JsonResource
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
            'fan' => [
                'id' => $this->fan->id,
                'username' => $this->fan->username,
                'first_name' => $this->fan->first_name,
                'last_name' => $this->fan->last_name,
                'user_image_url' => $this->fan->user_image_url,
                'verified' => $this->fan->verified,
            ],
            'creator' => [
                'id' => $this->creator->id,
                'username' => $this->creator->username,
                'first_name' => $this->creator->first_name,
                'last_name' => $this->creator->last_name,
                'user_image_url' => $this->creator->user_image_url,
                'verified' => $this->creator->verified,
            ],
            'amount_paid_in_pay_per_view' => $this->amount_paid_in_pay_per_view,
            'amount_paid_in_subscription' => $this->amount_paid_in_subscription,
            'amount_paid_in_stream_tip' => $this->amount_paid_in_stream_tip,
            'amount_paid_in_tip' => $this->amount_paid_in_tip,
            'cumulative_amount_spent_on_creator_by_fan' => $this->cumulative_amount_spent_on_creator_by_fan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

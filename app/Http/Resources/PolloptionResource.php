<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PolloptionResource extends JsonResource
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
            'poll' => [
                'id' => $this->poll->id,
                'questionnaire' => $this->poll->questionnaire,
                'close_time' => $this->poll->close_time,
                'user' => [
                    'id' => $this->poll->user->id,
                    'username' => $this->poll->user->username,
                    'first_name' => $this->poll->user->first_name,
                    'last_name' => $this->poll->user->last_name,
                    'user_image_url' => $this->poll->user->user_image_url,
                    'verified' => $this->poll->user->verified,
                ],
            ],
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'option' => $this->option,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollresponseResource extends JsonResource
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
            'poll_option_selection' => [
                'id' => $this->polloption->user->id,
                'text_response' => $this->polloption->user->text_response,
                'poll' => [
                    'id' => $this->polloption->poll->id,
                    'questionnaire' => $this->polloption->poll->questionnaire,
                    'close_time' => $this->polloption->poll->close_time,
                ],
                'user' => [
                    'id' => $this->polloption->user->id,
                    'username' => $this->polloption->user->username,
                    'first_name' => $this->polloption->user->first_name,
                    'last_name' => $this->polloption->user->last_name,
                    'user_image_url' => $this->polloption->user->user_image_url,
                    'verified' => $this->polloption->user->verified,
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
            'amount_donated' => $this->amount_donated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PolloptionResource;
use App\Http\Resources\PollresponseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
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
            // 'polloptions' => PolloptionResource::collection($this->polloptions),
            // 'pollresponses' => PollresponseResource::collection($this->pollresponses),
            'options' => $this->polloptions,
            'responses' => $this->pollresponses,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'questionnaire' => $this->questionnaire,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

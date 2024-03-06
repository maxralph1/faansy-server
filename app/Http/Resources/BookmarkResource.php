<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResource extends JsonResource
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
            // 'user' => $this->user_id,
            // 'post' => $this->post_id,
            // 'post' => $this->post,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            'post' => [
                'id' => $this->post->id,
                'body' => $this->post->body,
                'image_url' => $this->post->image_url,
                'video_url' => $this->post->video_url,
                'pinned' => $this->post->pinned,
                'pinned_at' => $this->post->pinned_at,
                'user' => [
                    'id' => $this->post->user->id,
                    'username' => $this->post->user->username,
                    'first_name' => $this->post->user->first_name,
                    'last_name' => $this->post->user->last_name,
                    'user_image_url' => $this->post->user->user_image_url,
                    'verified' => $this->post->user->verified,
                ],
                'comments' => PostcommentResource::collection($this->post->comments),
                'likes' => PostlikeResource::collection($this->post->likes),
                'pay_per_view' => $this->post->pay_per_view,
                'payperviewamount' => $this->post->payperviewamount,
                'repost' => $this->post->repost,
                'repost_original_id' => $this->post->repost_original_id,
                'repost_body' => $this->post->repost_body,
                'repost_original_post_timestamp' => $this->post->repost_original_post_timestamp,
                'created_at' => $this->post->created_at,
                'updated_at' => $this->post->updated_at,
                'deleted_at' => $this->post->deleted_at,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

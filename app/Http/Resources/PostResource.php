<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BookmarkResource;
use App\Http\Resources\PostlikeResource;
use App\Http\Resources\PostcommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'pay_per_view' => $this->pay_per_view,
            'pay_per_view_amount' => $this->pay_per_view_amount,
            // 'image_url' => $this->image_url,
            'image_url' => $this->when($this->pay_per_view == false, $this->image_url),
            // 'video_url' => $this->video_url,
            'video_url' => $this->when($this->pay_per_view == false, $this->video_url),
            'pinned' => $this->pinned,
            'pinned_at' => $this->pinned_at,
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'user_image_url' => $this->user->user_image_url,
                'verified' => $this->user->verified,
            ],
            // 'comments' => $this->comments,
            'comments' => PostcommentResource::collection($this->comments),
            'likes' => PostlikeResource::collection($this->likes),
            'bookmarks' => BookmarkResource::collection($this->bookmarks),
            'repost' => $this->repost,
            'repost_original_id' => $this->repost_original_id,
            'repost_body' => $this->repost_body,
            'repost_original_post_timestamp' => $this->repost_original_post_timestamp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'body',
        'image_url',
        'image_url_2',
        'image_url_3',
        'image_url_4',
        'video_url',
        'pay_per_view',
        'payperviewamount',
        'scheduled_live_time',
        'repost',
        'repost_original_id',
        'repost_body',
        'repost_original_post_timestamp',
        // 'pinned',
        // 'pinned_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Postcomment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Postlike::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function postimages(): HasMany
    {
        return $this->hasMany(Postimage::class);
    }

    public function postvideo(): HasOne
    {
        return $this->hasOne(Postvideo::class);
    }

    public function payperviewamount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'body',
        'video_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

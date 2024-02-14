<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Streamlike extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'stream_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }
}

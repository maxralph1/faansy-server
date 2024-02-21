<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pollresponse extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'polloption_id',
        'poll_id',
        'user_id',
        'text_response',
    ];

    public function polloption(): BelongsTo
    {
        return $this->belongsTo(Polloption::class);
    }

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

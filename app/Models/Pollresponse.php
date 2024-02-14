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
        'poll_id',
        'user_id',
        'poll_option_selection',
        'text_response',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

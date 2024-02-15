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
        'poll_option_selection_id',
        'user_id',
        'text_response',
    ];

    public function polloption(): BelongsTo
    {
        return $this->belongsTo(Polloption::class, 'poll_option_selection_id');
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

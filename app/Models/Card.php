<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'country',
        'state_province',
        'address',
        'city',
        'email',
        'card_number',
        'name_on_card',
        'expiration',
        'cvc',
        'legal_age',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

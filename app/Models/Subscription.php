<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'subscribed_id',
        'subscriber_id',
        'subscription_amount_paid',
    ];

    public function subscribed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subscribed_id');
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }

    public function subscription_amount_paid(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}

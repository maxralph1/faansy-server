<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fanactivity extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'fan_id',
        'creator_id',
        'title',
        'amount_paid_in_pay_per_view',
        'amount_paid_in_subscription',
        'amount_paid_in_stream_tip',
        'amount_paid_in_tip',
        'cumulative_amount_spent_on_creator_by_fan',
    ];

    public function fan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fan_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function amount_paid_in_pay_per_view(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function amount_paid_in_subscription(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function amount_paid_in_stream_tip(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function amount_paid_in_tip(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function cumulative_amount_spent_on_creator_by_fan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}

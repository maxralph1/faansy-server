<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory, HasUlids;
    // use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'notification_type',
        'monies_if_any',
        'reference_id_to_resource',
        'transactor_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transactor_id');
    }

    public function monies_if_any(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}

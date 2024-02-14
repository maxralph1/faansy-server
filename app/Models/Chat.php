<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'participator_1_id',
        'participator_2_id',
        'slug',
    ];

    public function participator_1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participator_1_id');
    }

    public function participator_2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participator_2_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}

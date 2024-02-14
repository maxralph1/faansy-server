<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restrict extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'restrictor_id',
        'restrictee_id',
    ];

    public function restrictor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restrictor_id');
    }

    public function restrictee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restrictee_id');
    }
}

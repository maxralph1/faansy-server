<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Userlike extends Model
{
    use HasFactory, HasUlids;
    // use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'liked_id',
        'liker_id',
    ];

    public function liked(): BelongsTo
    {
        return $this->belongsTo(User::class, 'liked_id');
    }

    public function liker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'liker_id');
    }
}

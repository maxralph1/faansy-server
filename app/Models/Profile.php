<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    // use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bio',
        'address',
        'website_url',
        'phone_number',
        'twitter_account',
        'google_account',
        'dark_mode',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Userverification extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'requesting_user_id',
        'approving_user_id',
        'verification_material_image_url',
        'approved',
        'approval_time',
        'rejected',
        'reason_for_rejection',
        'rejection_time'
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requesting_user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approving_user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'beneficiary_id',
        'transactor_id',
        'transaction_type',
        'amount',
        'reference_id_to_resource'
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    public function transactor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transactor_id');
    }
}

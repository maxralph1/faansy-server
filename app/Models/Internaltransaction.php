<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Internaltransaction extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'transaction_type',
        'amount',
        'reference_id_to_resource',
        'reference_id_to_transaction',
    ];

    // public function amount(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value / 100,
    //         set: fn ($value) => $value * 100
    //     );
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'payout_method',
        'payout_details',
        'status',
        'transaction_password_verified_at',
    ];

    protected $casts = [
        'payout_details'                    => 'array',
        'transaction_password_verified_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

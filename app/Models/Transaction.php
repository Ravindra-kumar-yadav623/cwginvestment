<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'tx_type',
        'source_type',
        'source_id',
        'amount',
        'balance_before',
        'balance_after',
        'currency',
        'reference_no',
        'remark',
        'transaction_password_verified_at',
    ];

    protected $casts = [
        'transaction_password_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }


     public function investment()
    {
        // Only valid if source_type = 'investment'
        return $this->belongsTo(UserInvestment::class, 'source_id');
    }
}

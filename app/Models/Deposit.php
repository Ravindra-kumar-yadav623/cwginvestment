<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_for',
        'request_wallet_address',
        'currency',
        'amount',
        'user_crypto_address',
        'proof_image',
        'status',
        'admin_remark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

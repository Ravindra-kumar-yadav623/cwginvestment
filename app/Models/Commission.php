<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commission extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'user_investment_id',
        'type',
        'level',
        'amount',
        'percentage',
        'status',
    ];

    public function user()
    {
        // who earned this commission
        return $this->belongsTo(User::class);
    }

    public function fromUser()
    {
        // whose activity generated this commission
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function investment()
    {
        return $this->belongsTo(UserInvestment::class, 'user_investment_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoiPayout extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_investment_id',
        'user_id',
        'amount',
        'roi_date',
        'status',
    ];

    protected $casts = [
        'roi_date' => 'date',
    ];

    public function investment()
    {
        return $this->belongsTo(UserInvestment::class, 'user_investment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }  
}

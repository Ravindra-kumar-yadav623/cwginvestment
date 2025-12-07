<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInvestment extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'investment_plan_id',
        'amount',
        'expected_roi_total',
        'earned_roi_total',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(InvestmentPlan::class, 'investment_plan_id');
    }

    public function roiPayouts()
    {
        return $this->hasMany(RoiPayout::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}

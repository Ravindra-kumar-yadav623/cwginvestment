<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestmentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_amount',
        'max_amount',
        'roi_percent_per_period',
        'roi_period',
        'duration_in_days',
        'is_compounding',
        'is_active',
    ];

    protected $casts = [
        'is_compounding' => 'boolean',
        'is_active'      => 'boolean',
    ];

    public function investments()
    {
        return $this->hasMany(UserInvestment::class);
    }
}

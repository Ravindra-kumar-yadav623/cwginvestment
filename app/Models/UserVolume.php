<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserVolume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'left_volume',
        'right_volume',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

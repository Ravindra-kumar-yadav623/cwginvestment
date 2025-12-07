<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNetwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sponsor_id',
        'upline_id',
        'position',
        'level',
    ];

    // The user this row belongs to
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sponsor for genealogy / referral tree
    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    // Upline in binary tree (placement)
    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }
}

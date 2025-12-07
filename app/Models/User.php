<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
  
    */
                
            protected $fillable = [
        'name',
        'email',
        'mobile',
        'country',
        'username',
        'password',
        'transaction_password',
        'transaction_password_set_at',
        'user_code',
        'sponsor_id',
        'position',
        'mt5_account_no',
        'kyc_status',
        'status',
        'email_verified_at',
        'mobile_verified_at',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'transaction_password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'transaction_password' => 'hashed',
            'transaction_password_set_at' => 'datetime',
            'mobile_verified_at'              => 'datetime',
        ];
    }

    // public function setPasswordAttribute($value)
    // {
    //     if ($value && !Hash::needsRehash($value)) {
    //         $this->attributes['password'] = Hash::make($value);
    //     } else {
    //         $this->attributes['password'] = $value;
    //     }
    // }

    // public function setTransactionPasswordAttribute($value)
    // {
    //     if ($value && !Hash::needsRehash($value)) {
    //         $this->attributes['transaction_password'] = Hash::make($value);
    //     } else {
    //         $this->attributes['transaction_password'] = $value;
    //     }
    // }

    /* ---------------- Relationships ---------------- */

    // Sponsor (who referred this user)
    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    // Direct downlines (people this user referred)
    public function downlines()
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    // User's placement / binary tree info
    public function network()
    {
        return $this->hasOne(UserNetwork::class);
    }

    // Binary volumes
    public function volume()
    {
        return $this->hasOne(UserVolume::class);
    }

    // Roles (admin, user etc.)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    // Wallets
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    // All transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Investments
    public function investments()
    {
        return $this->hasMany(UserInvestment::class);
    }

    // ROI payouts
    public function roiPayouts()
    {
        return $this->hasMany(RoiPayout::class);
    }

    // Commissions earned by this user
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    // Commissions generated from this user's activity (others earn)
    public function commissionsFromMe()
    {
        return $this->hasMany(Commission::class, 'from_user_id');
    }

    // Deposits
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    // Withdrawals
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    // OTPs
    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    // Login logs
    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure admin role exists 
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator']
        );

        // 2. Create admin user (if not exists)
        $admin = User::firstOrCreate(
            ['email' => 'admin@capitalwealth.com'], // unique identifier
            [
                'name'                     => 'Super Admin',
                'mobile'                   => '9999999999',
                'country'                  => 'India',
                'username'                 => 'admin',

                'password'                 => Hash::make('Admin@123'),      // change in production
                'transaction_password'     => Hash::make('Trx@123'),        // change in production
                'transaction_password_set_at' => now(),

                'sponsor_id'               => null,
                'position'                 => null,
                'mt5_account_no'           => null,

                'kyc_status'               => 'approved',
                'status'                   => 'active',

                'user_code'                => 'TEMP', // will fix after save
            ]
        );

        // 3. Generate user_code like CWG000001 (if still TEMP)
        if ($admin->user_code === 'TEMP') {
            $admin->user_code = 'CWG' . str_pad($admin->id, 6, '0', STR_PAD_LEFT);
            $admin->save();
        }

        // 4. Attach admin role
        if (!$admin->roles()->where('roles.id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id);
        }

        // 5. Create default wallets if not exist
        $walletTypes = ['main', 'investment', 'commission', 'roi', 'bonus'];

        foreach ($walletTypes as $type) {
            $wallet = Wallet::firstOrCreate(
                [
                    'user_id' => $admin->id,
                    'type'    => $type,
                ],
                [
                    'balance' => 0,
                ]
            );

            // For admin: set MAIN wallet default balance = 1500
            if ($type === 'main' && $wallet->balance == 0) {
                $wallet->balance = 1500;
                $wallet->save();
            }
        }
    }
}

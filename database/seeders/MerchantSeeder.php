<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@litepay.com'],
            [
                'name' => 'Admin System',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Merchant user
        $user = User::firstOrCreate(
            ['email' => 'merchant@toko.com'],
            [
                'name' => 'Toko Serba Ada',
                'password' => Hash::make('password'),
                'role' => 'merchant',
            ]
        );

        // Create Merchant Profile
        // Create Merchant Profile
        Merchant::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Toko Serba Ada Official',
                'api_key' => 'SB-MID-SERVER-' . Str::random(10),
                'api_secret' => Str::random(32),
                'callback_url' => 'https://webhook.site/#!/view/uuid',
                'status' => 'active',
            ]
        );

        // Specific User (Fadhil)
        $fadhil = User::firstOrCreate(
            ['email' => 'fadhilmarhas@gmail.com'],
            [
                'name' => 'Fadhil Merchant',
                'password' => Hash::make('password'),
                'role' => 'merchant',
            ]
        );

        Merchant::firstOrCreate(
            ['user_id' => $fadhil->id],
            [
                'name' => 'Fadhil Store',
                'api_key' => 'SB-MID-SERVER-' . Str::random(10),
                'api_secret' => Str::random(32),
                'status' => 'active',
            ]
        );
    }
}

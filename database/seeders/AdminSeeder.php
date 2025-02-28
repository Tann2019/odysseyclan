<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@odysseyclan.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create admin member profile
        Member::create([
            'user_id' => $admin->id,
            'discord_id' => 'admin#0001',
            'username' => 'OdysseyAdmin',
            'rank' => 'commander',
            'is_active' => true,
            'verification_status' => 'verified',
            'verified_at' => now(),
            'achievements' => [
                [
                    'id' => 'admin_role',
                    'name' => 'Administrator',
                    'description' => 'Site administrator with full privileges',
                    'date_earned' => now()->format('Y-m-d')
                ]
            ]
        ]);
        
        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@odysseyclan.com');
        $this->command->info('Password: password');
    }
}
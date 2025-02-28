<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Member;
use Illuminate\Console\Command;

class PromoteUserToAdmin extends Command
{
    protected $signature = 'user:promote {email : The email of the user to promote}';
    protected $description = 'Promote a user to admin status';

    public function handle()
    {
        $email = $this->argument('email');
        
        // Find the user by email
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }
        
        // Check if the user is already an admin
        if ($user->is_admin) {
            $this->info("User {$email} is already an admin.");
            return 0;
        }
        
        // Update the user to be an admin
        $user->update(['is_admin' => true]);
        
        $this->info("User {$email} has been promoted to admin.");
        
        // Check if the user has a member profile
        $member = $user->member;
        
        if ($member->exists) {
            // Update member status if they aren't already verified
            if (!$member->isVerified()) {
                $member->update([
                    'verification_status' => 'verified',
                    'verified_at' => now(),
                    'verification_notes' => 'Automatically verified when promoted to admin.'
                ]);
                $this->info("Member profile verified.");
            }
            
            // Optionally, update rank to commander
            if ($this->confirm('Would you like to promote this user to Commander rank?', true)) {
                $member->update(['rank' => 'commander']);
                $this->info("Member promoted to Commander rank.");
            }
        } else {
            if ($this->confirm('This user does not have a member profile. Would you like to create one?', true)) {
                // Create a new member profile
                $username = $this->ask('Enter a username for this member', $user->name);
                $discordId = $this->ask('Enter the Discord ID for this member', 'admin#' . rand(1000, 9999));
                
                Member::create([
                    'user_id' => $user->id,
                    'discord_id' => $discordId,
                    'username' => $username,
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
                
                $this->info("Member profile created for admin.");
            }
        }
        
        return 0;
    }
}
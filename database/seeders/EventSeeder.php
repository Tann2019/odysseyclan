<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first admin user
        $admin = User::where('is_admin', true)->first();
        
        if (!$admin) {
            // If no admin exists, create one or use the first user
            $admin = User::first();
        }

        if (!$admin) {
            $this->command->warn('No users found. Please create a user first before running the EventSeeder.');
            return;
        }

        $events = [
            [
                'title' => 'Championship Tournament 2025',
                'description' => "Join us for the ultimate showdown in our annual championship tournament! This year's competition will feature intense battles across multiple game modes with substantial prizes for the victors.\n\nPrepare for glory, warriors!",
                'type' => 'tournament',
                'image_url' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=800&h=400&fit=crop',
                'event_date' => Carbon::now()->addDays(15)->setTime(20, 0),
                'registration_deadline' => Carbon::now()->addDays(10)->setTime(23, 59),
                'max_participants' => 32,
                'is_active' => true,
                'is_featured' => true,
                'additional_info' => [
                    'prize_pool' => '$5,000',
                    'requirements' => ['Minimum rank: Veteran', 'Discord required', 'Streaming encouraged'],
                    'format' => 'Single elimination bracket',
                    'rules' => 'Standard tournament rules apply'
                ],
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Weekly Training Session',
                'description' => "Sharpen your skills with our veteran players! This week we'll focus on advanced tactics and team coordination.\n\nAll skill levels welcome - learn from the best!",
                'type' => 'training',
                'image_url' => 'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?w=800&h=400&fit=crop',
                'event_date' => Carbon::now()->addDays(3)->setTime(19, 0),
                'registration_deadline' => null,
                'max_participants' => null,
                'is_active' => true,
                'is_featured' => false,
                'additional_info' => [
                    'focus_areas' => ['Team coordination', 'Advanced tactics', 'Map control'],
                    'requirements' => ['Discord with mic', 'Positive attitude'],
                    'duration' => '2 hours'
                ],
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Community Game Night',
                'description' => "Relax and have fun with fellow clan members! Tonight we're playing variety games and just enjoying each other's company.\n\nBring your favorite games and let's have a blast!",
                'type' => 'community',
                'image_url' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&h=400&fit=crop',
                'event_date' => Carbon::now()->addDays(1)->setTime(21, 0),
                'registration_deadline' => null,
                'max_participants' => null,
                'is_active' => true,
                'is_featured' => false,
                'additional_info' => [
                    'games' => ['Among Us', 'Fall Guys', 'Jackbox Games', 'Minecraft'],
                    'requirements' => ['Just show up and have fun!'],
                    'voice_chat' => 'Discord general channel'
                ],
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Odyssey Anniversary Celebration',
                'description' => "Celebrate 3 amazing years of Odyssey Clan! Join us for special events, giveaways, and commemorative matches.\n\nThis is a milestone worth celebrating together!",
                'type' => 'special',
                'image_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=800&h=400&fit=crop',
                'event_date' => Carbon::now()->addDays(30)->setTime(18, 0),
                'registration_deadline' => Carbon::now()->addDays(25)->setTime(23, 59),
                'max_participants' => null,
                'is_active' => true,
                'is_featured' => true,
                'additional_info' => [
                    'activities' => ['Anniversary tournament', 'Giveaway contests', 'Photo/video contests', 'Special commemorative matches'],
                    'prizes' => ['Gaming gear', 'Steam gift cards', 'Exclusive clan merchandise'],
                    'duration' => 'Full weekend event'
                ],
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Rookie Bootcamp',
                'description' => "New to the clan? This bootcamp is designed specifically for our newest members to get up to speed quickly.\n\nLearn the ropes from experienced veterans!",
                'type' => 'training',
                'image_url' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=800&h=400&fit=crop',
                'event_date' => Carbon::now()->addDays(7)->setTime(17, 0),
                'registration_deadline' => Carbon::now()->addDays(5)->setTime(23, 59),
                'max_participants' => 16,
                'is_active' => true,
                'is_featured' => false,
                'additional_info' => [
                    'target_audience' => 'New members (Recruit rank)',
                    'topics' => ['Clan rules and etiquette', 'Basic strategies', 'Communication protocols'],
                    'mentors' => 'Veteran and Captain rank members',
                    'requirements' => ['Recruit rank', 'Discord with mic']
                ],
                'created_by' => $admin->id,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }

        $this->command->info('Sample events created successfully!');
    }
}
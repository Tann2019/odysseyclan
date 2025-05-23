<?php

namespace Database\Seeders;

use App\Models\Streamer;
use Illuminate\Database\Seeder;

class StreamerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $streamers = [
            [
                'twitch_username' => 'raabbits',
                'display_name' => 'Raabbits',
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'twitch_username' => 'odysseyclangaming',
                'display_name' => 'Odyssey Clan Gaming',
                'priority' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($streamers as $streamerData) {
            Streamer::updateOrCreate(
                ['twitch_username' => $streamerData['twitch_username']],
                $streamerData
            );
        }
    }
}
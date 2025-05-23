<?php

namespace App\Console\Commands;

use App\Services\TwitchService;
use Illuminate\Console\Command;

class UpdateStreamStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Twitch stream statuses for all active streamers';

    /**
     * Execute the console command.
     */
    public function handle(TwitchService $twitchService)
    {
        $this->info('Starting Twitch stream status update...');
        
        $updated = $twitchService->updateAllStreamStatuses();
        
        // Clear the live streamer cache to force refresh
        $twitchService->clearLiveStreamerCache();
        
        $this->info("Successfully updated {$updated} streamer statuses.");
        
        return Command::SUCCESS;
    }
}
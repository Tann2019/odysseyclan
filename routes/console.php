<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('odyssey:check-live-streamers', function () {
    $this->comment('Checking live streamers...');
    Artisan::call('odyssey:check-live-streamers');
    $this->info('Live streamers checked successfully.');
})->purpose('Check live streamers and update their status')->everyFiveMinutes();

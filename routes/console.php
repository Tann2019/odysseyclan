<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Schedule::command('odyssey:check-live-streamers')
    ->everyThreeMinutes()
    ->description('Check live streamers and update their status');

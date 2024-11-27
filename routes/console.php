<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('schedule:daily', function (Schedule $schedule) {
    $schedule->command('app:mark-absences')
        ->dailyAt('6:00')
        ->timezone('Asia/Kathmandu');
});

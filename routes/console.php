<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Mail\PostCountMail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::call(function () {
// Mail::to('admin1@example.com')->send(new PostCountMail());
// })->everyTwoMinutes();
// Artisan::command('test:cron', function () {
//     $this->info('TestCron command executed.');
// })->purpose('Testing Cron Command');

Schedule::command('test:cron')->everyMinute();

// Schedule::commond('test:cron')->everyTwoMinutes();
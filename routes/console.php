<?php

use App\Enums\UserStatus;
use App\Jobs\SendVaccinationReminderJob;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// update to get a schedule
Schedule::command('app:update-user-status',[UserStatus::NOT_SCHEDULED->value])->everyFiveMinutes(); // every 5 minute update user status
// update to vaccinated
Schedule::command('app:update-user-status',[UserStatus::VACCINATED->value])->dailyAt('00:00'); // every day update status vaccinated
// send mail

Schedule::call(function () {  SendVaccinationReminderJob::dispatch(); })->dailyAt('21:00'); // mail Scheduled at 9 PM daily

<?php

namespace App\Jobs;

use App\Enums\UserStatus;
use App\Mail\VaccinationReminder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendVaccinationReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $users = User::where('status', UserStatus::SCHEDULED->value)
            ->whereDate('scheduled_date', '=', now()->addDay()->format('Y-m-d'))
            ->get();
        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new VaccinationReminder($user));
            } catch (\Exception $e) {
                logger()->error($e);
            }
        }
    }
}

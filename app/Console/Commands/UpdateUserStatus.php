<?php

namespace App\Console\Commands;

use App\Enums\UserStatus;
use App\Http\Controllers\RegistrationController;
use Illuminate\Console\Command;

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-status {status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update user status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Call your updateStatus method
        $controller = new RegistrationController(); // Use the appropriate controller

        if ($this->argument('status') == UserStatus::NOT_SCHEDULED->value) {
            $controller->updateStatus();
            $this->info('User status updated successfully to ' . UserStatus::NOT_SCHEDULED->value);
        } else {
            $controller->updateToVaccinatedStatus();
            $this->info('User status updated successfully to ' . UserStatus::VACCINATED->value);
        }
    }
}

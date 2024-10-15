<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Mail\VaccinationReminder;
use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{

    public function index(){
        return view('index');
    }

    public function registerPage() {
        $data['vaccine_centers'] = VaccineCenter::all();
        return view('registration',$data);
    }


    public function searchStatus(Request $request){
        $validated = $request->validate([
            'nid' => 'required',
        ]);
        $data['user'] = User::where('nid',$validated['nid'])->first();
        if (!isset($data['user'])) {
            $message = "This NID is not registered for vaccination! Please, <small><a href='" . route('register') . "'>Register</a>&nbsp;from here</small>";
            return redirect()->back()->with([
                'message' => $message,
                'alert-type' => 'danger',
            ]);
        }
        return view('user_info',$data);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nid' => 'required|unique:users,nid',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'vaccine_center' => 'required|exists:vaccine_centers,id',
        ]);

        // Check vaccine center capacity and assign schedule
        $center = VaccineCenter::find($validated['vaccine_center']);
//        $scheduledDate = $this->getNextAvailableDate($center);

        // Register the user
        $user = User::create([
            'nid' => $validated['nid'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'serial' => 0,
            'vaccine_center' => $center->id,
            'status' => UserStatus::NOT_SCHEDULED->value,
//            'scheduled_date' => $scheduledDate,
        ]);
        return redirect()->back()->with(['message' => 'Registration successful', 'alert-type' => 'success']);
    }

    private function getNextAvailableDateAndSerial(VaccineCenter $center): array
    {
        $dailyLimit = $center->daily_limit;
        $today = now();
        $nextAvailableDate = $today->clone();

        do {
            $usersCount = $center->users()
                ->where('scheduled_date', $nextAvailableDate->format('Y-m-d'))
                ->selectRaw('count(*) as count, max(serial) as last_serial')
                ->first();

            // If the count is less than the daily limit, return the available date and next serial
            if ($usersCount && $usersCount->count < $dailyLimit) {
                $nextSerial = $usersCount->last_serial ? $usersCount->last_serial + 1 : 1;
                return [$nextAvailableDate->format('Y-m-d'), $nextSerial];
            }

            $nextAvailableDate->addDay();

        } while (true);
    }


    public function updateStatus(): void
    {
        User::where('status', UserStatus::NOT_SCHEDULED->value)
            ->whereNull('scheduled_date')
            ->orderBy('created_at', 'asc')  // First-come, first-serve based on creation time
            ->with('vaccineCenter')
            ->chunk(100, function ($users) {
                DB::transaction(function () use ($users) {
                    foreach ($users as $user) {
                        $center = $user->vaccineCenter;
                        if ($center) {
                            list($scheduledDate, $nextSerial) = $this->getNextAvailableDateAndSerial($center);

                            $user->scheduled_date = $scheduledDate;
                            $user->serial = $nextSerial;
                            $user->status = UserStatus::SCHEDULED->value;
                            $user->save();
                        }
                    }
                });
            });
    }

    public function updateToVaccinatedStatus(): void
    {
        $today = now()->format('Y-m-d');
        User::where('status','=', UserStatus::SCHEDULED->value)
            ->where('scheduled_date', '<', $today)
            ->chunk(100, function ($users) {
                DB::transaction(function () use ($users) {
                    foreach ($users as $user) {
                        $user->update(['status' => UserStatus::VACCINATED->value]);
                    }
                });
            });
    }

    public function sendMail()
    {
        $user = User::first();

        try {
            Mail::to($user->email)->send(new VaccinationReminder($user));
        } catch (\Exception $e) {
            logger()->error($e);
        }
    }
}

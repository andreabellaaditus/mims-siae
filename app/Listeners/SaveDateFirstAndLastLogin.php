<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class SaveDateFirstAndLastLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Viene Registrata la data del login
        // se primo login anche il first_login_at altrimenti solo il last_login_at

        $dateLogin = Carbon::now()->format("Y-m-d H:i:s");

        if (isset($event->user->first_login_at)) {
            User::where('id', $event->user->id)
                ->update(['last_login_at' => $dateLogin,]);
        } else {
            User::where('id', $event->user->id)
                ->update(['first_login_at' => $dateLogin,'last_login_at' => $dateLogin,]);
        }
    }
}

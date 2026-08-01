<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class HandleUserLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        if ($user instanceof User) {
            $band = $user->bands()->first();

            if ($band) {
                Session::put('currentBand', $band->id);
                return;
            }
        }
        error_log('Could not write band into session for user (' . $user->id . ')!');
    }
}

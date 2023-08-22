<?php

namespace App\Listeners;

use App\Events\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class storeUserLoginHistory
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
    public function handle(LoginHistory $event): void
    {
      $info = $event->str;
        Log::channel('stderr')->notice("Listener LoginHistory START");

        Log::channel('stderr')->notice("variable str from Event: ".$info);


    }
}

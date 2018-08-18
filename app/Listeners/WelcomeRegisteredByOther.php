<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

use App\Events\RegisteredByOther;

use App\Mail\WelcomeWithPass;

class WelcomeRegisteredByOther
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RegisteredByOther $event)
    {
        // send welcome email!
        Mail::to($event->user->email)->send(new WelcomeWithPass($event->user,$event->password));
    }
}

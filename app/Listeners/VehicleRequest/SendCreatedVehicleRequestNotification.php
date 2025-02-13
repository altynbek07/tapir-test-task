<?php

namespace App\Listeners\VehicleRequest;

use App\Events\VehicleRequest\CreatedEvent;
use App\Notifications\NewVehicleRequestNotification;
use Illuminate\Support\Facades\Notification;

class SendCreatedVehicleRequestNotification
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
    public function handle(CreatedEvent $event): void
    {
        Notification::route('mail', config('tapir.admin_email'))
            ->notify(new NewVehicleRequestNotification($event->vehicleRequest));
    }
}

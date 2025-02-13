<?php

namespace App\Listeners\VehicleRequest;

use App\Events\VehicleRequest\CreatedEvent;
use App\Jobs\SendVehicleRequestToCrmJob;

class SendCreatedVehicleRequestToCrm
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
        SendVehicleRequestToCrmJob::dispatch($event->vehicleRequest);
    }
}

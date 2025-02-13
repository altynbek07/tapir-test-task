<?php

namespace App\Events\VehicleRequest;

use App\Models\VehicleRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public VehicleRequest $vehicleRequest)
    {
        //
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\SendVehicleRequestToCrmJob;
use App\Models\VehicleRequest;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'app:test-command';

    protected $description = 'Test command';

    public function handle(): void
    {
        SendVehicleRequestToCrmJob::dispatch(VehicleRequest::find(6));
    }
}

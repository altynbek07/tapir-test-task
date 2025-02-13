<?php

namespace App\Jobs;

use App\Contracts\CrmClientInterface;
use App\DataTransferObjects\CrmRequestDto;
use App\Models\VehicleRequest;
use App\Notifications\CrmRequestFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SendVehicleRequestToCrmJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;

    public int $backoff = 60;

    public function __construct(
        private readonly VehicleRequest $vehicleRequest
    ) {}

    public function handle(CrmClientInterface $client): void
    {
        $dto = new CrmRequestDto(
            phone: $this->vehicleRequest->phone,
            vin: $this->vehicleRequest->vehicle->vin
        );

        if ($client->sendRequest($dto)) {
            $this->vehicleRequest->update([
                'crm_status' => 'sent',
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        $this->vehicleRequest->update([
            'crm_status' => 'failed',
        ]);

        Notification::route('mail', config('tapir.admin_email'))->notify(new CrmRequestFailed($this->vehicleRequest));
    }
}

<?php

namespace App\Jobs;

use App\Contracts\CrmClient;
use App\DataTransferObjects\CrmRequestDto;
use App\Models\VehicleRequest;
use App\Notifications\CrmRequestFailed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class RetryCrmRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 300; // 5 минут между попытками

    public function __construct(
        private readonly VehicleRequest $vehicleRequest
    ) {}

    public function handle(CrmClient $client): void
    {
        $dto = new CrmRequestDto(
            phone: $this->vehicleRequest->phone,
            vin: $this->vehicleRequest->vehicle->vin
        );

        if ($client->sendRequest($dto)) {
            $this->vehicleRequest->update([
                'crm_status' => 'sent',
            ]);

            return;
        }

        $this->vehicleRequest->update([
            'crm_status' => 'failed',
            'retry_count' => $this->vehicleRequest->retry_count + 1,
            'last_retry_at' => now(),
        ]);

        if ($this->vehicleRequest->retry_count >= $this->tries) {
            Notification::route('mail', config('admin.email'))
                ->notify(new CrmRequestFailed($this->vehicleRequest));
        }
    }
}

<?php

namespace App\Services;

use App\Contracts\CrmClient;
use App\DataTransferObjects\CrmRequestDto;
use App\Jobs\RetryCrmRequest;
use App\Mail\VehicleRequestCreated;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use Illuminate\Support\Facades\Mail;

class VehicleRequestService
{
    public function __construct(
        private readonly CrmClient $crmClient
    ) {}

    public function createRequest(Vehicle $vehicle, string $phone): VehicleRequest
    {
        $request = VehicleRequest::create([
            'vehicle_id' => $vehicle->id,
            'phone' => $phone,
        ]);

        // Отправляем email
        Mail::to(config('mail.from.address'))
            ->send(new VehicleRequestCreated($request));

        // Пытаемся отправить в CRM
        $this->sendToCrm($request);

        return $request;
    }

    private function sendToCrm(VehicleRequest $request): void
    {
        $dto = new CrmRequestDto(
            phone: $request->phone,
            vin: $request->vehicle->vin
        );

        if ($this->crmClient->sendRequest($dto)) {
            $request->update([
                'crm_status' => 'sent',
            ]);

            return;
        }

        $request->update([
            'crm_status' => 'pending',
            'retry_count' => $request->retry_count + 1,
            'last_retry_at' => now(),
        ]);

        // Запускаем Job для повторных попыток
        RetryCrmRequest::dispatch($request)->delay(now()->addMinutes(5));
    }
}

<?php

namespace App\Services\Crm;

use App\Contracts\CrmClient;
use App\DataTransferObjects\CrmRequestDto;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class TapirCrmClient implements CrmClient
{
    public function __construct(
        private readonly string $baseUrl = 'https://crm.tapir.ws/api/crm'
    ) {}

    public function sendRequest(CrmRequestDto $dto): bool
    {
        try {
            $response = Http::post($this->baseUrl, $dto->toArray());

            return $response->successful();
        } catch (RequestException $e) {
            return false;
        }
    }
}

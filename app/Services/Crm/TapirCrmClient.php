<?php

namespace App\Services\Crm;

use App\Contracts\CrmClientInterface;
use App\DataTransferObjects\CrmRequestDto;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class TapirCrmClient implements CrmClientInterface
{
    public function sendRequest(CrmRequestDto $dto): bool
    {
        try {
            $response = Http::post(config('tapir.crm_url'), $dto->toArray());

            return $response->successful();
        } catch (RequestException $e) {
            return false;
        }
    }
}

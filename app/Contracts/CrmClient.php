<?php

namespace App\Contracts;

use App\DataTransferObjects\CrmRequestDto;

interface CrmClient
{
    public function sendRequest(CrmRequestDto $dto): bool;
}

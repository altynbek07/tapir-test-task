<?php

namespace App\Contracts;

use App\DataTransferObjects\CrmRequestDto;

interface CrmClientInterface
{
    public function sendRequest(CrmRequestDto $dto): bool;
}

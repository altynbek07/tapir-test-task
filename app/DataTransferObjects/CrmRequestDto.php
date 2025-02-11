<?php

namespace App\DataTransferObjects;

readonly class CrmRequestDto
{
    public function __construct(
        public string $phone,
        public string $vin,
    ) {}

    public function toArray(): array
    {
        return [
            'phone' => $this->phone,
            'VIN' => $this->vin,
        ];
    }
}

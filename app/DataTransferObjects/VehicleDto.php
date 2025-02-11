<?php

namespace App\DataTransferObjects;

readonly class VehicleDto
{
    public function __construct(
        public string $brand,
        public string $model,
        public string $vin,
        public int $price,
        public ?int $year = null,
        public ?int $mileage = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            brand: $data['brand'],
            model: $data['model'],
            vin: $data['vin'],
            price: (int)$data['price'],
            year: isset($data['year']) ? (int)$data['year'] : null,
            mileage: isset($data['mileage']) ? (int)$data['mileage'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'vin' => $this->vin,
            'price' => $this->price,
            'year' => $this->year,
            'mileage' => $this->mileage,
        ];
    }
}

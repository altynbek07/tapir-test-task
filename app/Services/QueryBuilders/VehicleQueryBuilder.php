<?php

namespace App\Services\QueryBuilders;

use App\Http\Requests\VehicleFilterRequest;
use Illuminate\Database\Eloquent\Builder;

class VehicleQueryBuilder
{
    private Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function filterByBrand(?string $brand): self
    {
        if ($brand !== null) {
            $this->query->where('brand', $brand);
        }

        return $this;
    }

    public function filterByModel(?string $model): self
    {
        if ($model !== null) {
            $this->query->where('model', $model);
        }

        return $this;
    }

    public function filterByType(?string $type): self
    {
        if ($type !== null) {
            $this->query->where('type', $type);
        }

        return $this;
    }

    public function filterByYearRange(?int $from, ?int $to): self
    {
        if ($from !== null) {
            $this->query->where('year', '>=', $from);
        }

        if ($to !== null) {
            $this->query->where('year', '<=', $to);
        }

        return $this;
    }

    public function filterByPriceRange(?int $more, ?int $less): self
    {
        if ($more !== null) {
            $this->query->where('price', '>=', $more);
        }

        if ($less !== null) {
            $this->query->where('price', '<=', $less);
        }

        return $this;
    }

    public function filterByMileageRange(?int $more, ?int $less): self
    {
        if ($more !== null) {
            $this->query->where('mileage', '>=', $more);
        }

        if ($less !== null) {
            $this->query->where('mileage', '<=', $less);
        }

        return $this;
    }

    public static function fromRequest(Builder $query, VehicleFilterRequest $request): Builder
    {
        return (new self($query))
            ->filterByBrand($request->get('brand'))
            ->filterByModel($request->get('model'))
            ->filterByType($request->get('type'))
            ->filterByYearRange(
                $request->get('year_from'),
                $request->get('year_to')
            )
            ->filterByPriceRange(
                $request->get('price_more'),
                $request->get('price_less')
            )
            ->filterByMileageRange(
                $request->get('mileage_more'),
                $request->get('mileage_less')
            )
            ->getQuery();
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }
}

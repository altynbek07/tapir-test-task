<?php

namespace App\Models;

use App\Events\VehicleRequest\CreatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class VehicleRequest extends Model
{
    use AsSource;

    protected $fillable = [
        'vehicle_id',
        'phone',
        'crm_status',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => CreatedEvent::class,
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}

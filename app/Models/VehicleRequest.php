<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleRequest extends Model
{
    protected $fillable = [
        'vehicle_id',
        'phone',
        'crm_status',
        'retry_count',
        'last_retry_at',
    ];

    protected $casts = [
        'last_retry_at' => 'datetime',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}

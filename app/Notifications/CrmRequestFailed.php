<?php

namespace App\Notifications;

use App\Models\VehicleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CrmRequestFailed extends Notification
{
    use Queueable;

    public function __construct(
        private readonly VehicleRequest $vehicleRequest
    ) {}

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject('CRM Request Failed')
            ->line('Failed to send vehicle request to CRM after multiple attempts.')
            ->line("Vehicle: {$this->vehicleRequest->vehicle->brand} {$this->vehicleRequest->vehicle->model}")
            ->line("VIN: {$this->vehicleRequest->vehicle->vin}")
            ->line("Phone: {$this->vehicleRequest->phone}")
            ->action('View in Admin Panel', url('/admin/vehicle-requests'));
    }
}

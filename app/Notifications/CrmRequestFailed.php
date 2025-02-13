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
            ->line('Phone: '.$this->vehicleRequest->phone)
            ->line('Brand: '.$this->vehicleRequest->vehicle->brand)
            ->line('Model: '.$this->vehicleRequest->vehicle->model)
            ->line('VIN: '.$this->vehicleRequest->vehicle->vin)
            ->action('View in Admin Panel', url('/admin/vehicle-request'));
    }
}

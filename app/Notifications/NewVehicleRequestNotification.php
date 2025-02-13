<?php

namespace App\Notifications;

use App\Models\VehicleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVehicleRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private VehicleRequest $vehicleRequest) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New vehicle request')
            ->line('New vehicle request created')
            ->line('Phone: '.$this->vehicleRequest->phone)
            ->line('Brand: '.$this->vehicleRequest->vehicle->brand)
            ->line('Model: '.$this->vehicleRequest->vehicle->model)
            ->line('VIN: '.$this->vehicleRequest->vehicle->vin)
            ->action('View in Admin Panel', url('/admin/vehicle-request'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vehicle_request_id' => $this->vehicleRequest->id,
        ];
    }
}

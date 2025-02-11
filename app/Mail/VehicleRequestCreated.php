<?php

namespace App\Mail;

use App\Models\VehicleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VehicleRequestCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly VehicleRequest $vehicleRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Vehicle Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vehicle-requests.created',
        );
    }
}

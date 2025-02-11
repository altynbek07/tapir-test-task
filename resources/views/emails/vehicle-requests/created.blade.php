<x-mail::message>
# New Vehicle Request

A new request has been created for vehicle:

<x-mail::panel>
Brand: {{ $vehicleRequest->vehicle->brand }}
Model: {{ $vehicleRequest->vehicle->model }}
VIN: {{ $vehicleRequest->vehicle->vin }}
Phone: {{ $vehicleRequest->phone }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> 
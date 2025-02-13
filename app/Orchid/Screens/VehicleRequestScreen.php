<?php

namespace App\Orchid\Screens;

use App\Jobs\SendVehicleRequestToCrmJob;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class VehicleRequestScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'requests' => VehicleRequest::with('vehicle')
                ->latest()
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Vehicle requests';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('requests', [
                TD::make('id', 'ID'),
                TD::make('phone', 'Phone'),
                TD::make('vehicle.brand', 'Brand'),
                TD::make('vehicle.model', 'Model'),
                TD::make('vehicle.vin', 'VIN'),
                TD::make('crm_status', 'CRM Status')
                    ->render(function (VehicleRequest $request) {
                        return match ($request->crm_status) {
                            'sent' => Button::make('Sent')
                                ->type(Color::SUCCESS)
                                ->disabled(),
                            'failed' => Button::make('Failed')
                                ->type(Color::DANGER)
                                ->disabled(),
                            default => Button::make('Pending')
                                ->type(Color::WARNING)
                                ->disabled(),
                        };
                    }),
                TD::make('actions', 'Actions')
                    ->render(function (VehicleRequest $request) {
                        if ($request->crm_status === 'failed') {
                            return Button::make('Retry send to CRM')
                                ->type(Color::PRIMARY)
                                ->method('retry')
                                ->parameters([
                                    'id' => $request->id,
                                ]);
                        }

                        return '';
                    }),
            ]),
        ];
    }

    public function retry(Request $request): void
    {
        $vehicleRequest = VehicleRequest::findOrFail($request->get('id'));

        SendVehicleRequestToCrmJob::dispatch($vehicleRequest);

        Toast::success('Request sent to CRM');
    }
}

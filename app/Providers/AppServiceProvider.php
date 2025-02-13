<?php

namespace App\Providers;

use App\Contracts\CrmClientInterface;
use App\Services\Crm\TapirCrmClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CrmClientInterface::class,
            TapirCrmClient::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

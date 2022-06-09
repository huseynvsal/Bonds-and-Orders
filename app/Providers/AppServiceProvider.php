<?php

namespace App\Providers;

use App\Interfaces\InterestDatesInterface;
use App\Interfaces\InterestPaymentsInterface;
use App\Services\InterestDatesService;
use App\Services\InterestPaymentsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InterestDatesInterface::class, InterestDatesService::class);
        $this->app->bind(InterestPaymentsInterface::class, InterestPaymentsService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

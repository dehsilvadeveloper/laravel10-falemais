<?php

namespace App\Domain;

use Illuminate\Support\ServiceProvider;
use App\Domain\Plan\Providers\PlanServiceProvider;
use App\Domain\Fare\Providers\FareServiceProvider;
use App\Domain\CallPrice\Providers\CallPriceServiceProvider;
use App\Domain\Simulation\Providers\SimulationServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register(): void
    {
        $this->app->register(PlanServiceProvider::class);
        $this->app->register(FareServiceProvider::class);
        $this->app->register(CallPriceServiceProvider::class);
        $this->app->register(SimulationServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     * 
     * @return void
     */
    public function boot(): void
    {
    }
}

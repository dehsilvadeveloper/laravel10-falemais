<?php

namespace App\Domain\Simulation\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Simulation\Services\SimulateCallPriceService;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;

class SimulationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->bindServiceClasses();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Bind repository classes for domain Simulation
     *
     * @return void
     */
    private function bindServiceClasses(): void
    {
        $this->app->bind(SimulateCallPriceServiceInterface::class, SimulateCallPriceService::class);
    }
}

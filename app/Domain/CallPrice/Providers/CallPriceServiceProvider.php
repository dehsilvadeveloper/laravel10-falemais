<?php

namespace App\Domain\CallPrice\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\CallPrice\Services\CalculateCallPriceService;
use App\Domain\CallPrice\Services\Interfaces\CalculateCallPriceServiceInterface;

class CallPriceServiceProvider extends ServiceProvider
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
     * Bind repository classes for domain Call Price
     * 
     * @return void
     */
    private function bindServiceClasses(): void
    {
        $this->app->bind(CalculateCallPriceServiceInterface::class, CalculateCallPriceService::class);
    }
}

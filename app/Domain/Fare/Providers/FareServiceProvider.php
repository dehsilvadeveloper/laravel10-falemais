<?php

namespace App\Domain\Fare\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Fare\Services\FareService;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;

class FareServiceProvider extends ServiceProvider
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
     * Bind repository classes for domain Fare
     * 
     * @return void
     */
    private function bindServiceClasses(): void
    {
        $this->app->bind(FareServiceInterface::class, FareService::class);
    }
}

<?php

namespace App\Domain;

use Illuminate\Support\ServiceProvider;
use App\Domain\Plan\Providers\PlanServiceProvider;
use App\Domain\Fare\Providers\FareServiceProvider;

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

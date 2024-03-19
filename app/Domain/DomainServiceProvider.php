<?php

namespace App\Domain;

use Illuminate\Support\ServiceProvider;
use App\Domain\Plan\Providers\PlanServiceProvider;

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

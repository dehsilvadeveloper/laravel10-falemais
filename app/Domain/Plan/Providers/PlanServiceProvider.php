<?php

namespace App\Domain\Plan\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Plan\Services\PlanService;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;

class PlanServiceProvider extends ServiceProvider
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
     * Bind repository classes for domain Plan
     *
     * @return void
     */
    private function bindServiceClasses(): void
    {
        $this->app->bind(PlanServiceInterface::class, PlanService::class);
    }
}

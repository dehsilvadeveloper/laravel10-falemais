<?php

namespace App\Infrastructure\Database;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Database\Eloquent\BaseRepositoryEloquent;
use App\Infrastructure\Database\Eloquent\Interfaces\RepositoryEloquentInterface;
use App\Infrastructure\Database\Eloquent\PlanRepositoryEloquent;
use App\Domain\Plan\Repositories\PlanRepositoryInterface;
use App\Infrastructure\Database\Eloquent\FareRepositoryEloquent;
use App\Domain\Fare\Repositories\FareRepositoryInterface;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register(): void
    {
        $this->bindBaseRepositoryClasses();
        $this->bindPlanRepositoryClasses();
        $this->bindFareRepositoryClasses();
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
     * Bind base repository classes
     * 
     * @return void
     */
    private function bindBaseRepositoryClasses(): void
    {
        $this->app->bind(RepositoryEloquentInterface::class, BaseRepositoryEloquent::class);
    }

    /**
     * Bind repository classes for domain Plan
     * 
     * @return void
     */
    private function bindPlanRepositoryClasses(): void
    {
        $this->app->bind(PlanRepositoryInterface::class, PlanRepositoryEloquent::class);
    }

    /**
     * Bind repository classes for domain Fare
     * 
     * @return void
     */
    private function bindFareRepositoryClasses(): void
    {
        $this->app->bind(FareRepositoryInterface::class, FareRepositoryEloquent::class);
    }
}

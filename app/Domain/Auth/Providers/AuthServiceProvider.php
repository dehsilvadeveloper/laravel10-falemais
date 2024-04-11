<?php

namespace App\Domain\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Auth\Services\AuthService;
use App\Domain\Auth\Services\Interfaces\AuthServiceInterface;

class AuthServiceProvider extends ServiceProvider
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
     * Bind repository classes for domain Auth
     *
     * @return void
     */
    private function bindServiceClasses(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }
}

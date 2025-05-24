<?php

namespace App\Providers;

use App\Domain\Repositories\PostDomainRepositoryInterface;
use App\Repositories\Domain\PostDomainRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PostDomainRepositoryInterface::class,
            PostDomainRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

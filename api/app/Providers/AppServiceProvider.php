<?php

namespace App\Providers;

use App\Domain\Repositories\PostDomainRepositoryInterface;
use App\Domain\Repositories\UserDomainRepositoryInterface;
use App\Repositories\Domain\PostDomainRepository;
use App\Repositories\Domain\UserDomainRepository;
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
        $this->app->bind(
            UserDomainRepositoryInterface::class,
            UserDomainRepository::class
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

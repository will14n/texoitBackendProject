<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    ProducerRepositoryInterface,
    StudioRepositoryInterface,
    MovieRepositoryInterface,
};
use App\Repositories\Eloquent\{
    ProducerEloquentORM,
    StudioEloquentORM,
    MovieEloquentORM,
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieEloquentORM::class);
        $this->app->bind(ProducerRepositoryInterface::class, ProducerEloquentORM::class);
        $this->app->bind(StudioRepositoryInterface::class, StudioEloquentORM::class);
    }
}

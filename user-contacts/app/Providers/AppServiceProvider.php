<?php

namespace App\Providers;

use App\Repositories\Eloquent\ContactRepository;
use App\Repositories\Eloquent\UserRepository;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\Domain\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(ContactRepositoryInterface::class,ContactRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

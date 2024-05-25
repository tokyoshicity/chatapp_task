<?php

namespace App\Providers;

use App\Contracts\UserContract;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserContract::class, function () {
            return new UserService();
        });
    }
}

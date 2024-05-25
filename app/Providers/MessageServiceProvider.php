<?php

namespace App\Providers;

use App\Contracts\MessageContract;
use App\Services\MessageService;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MessageContract::class, function () {
            return new MessageService();
        });
    }
}

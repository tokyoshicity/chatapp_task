<?php

namespace App\Providers;

use App\Contracts\ChatContract;
use App\Services\ChatService;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ChatContract::class, function () {
            return new ChatService();
        });
    }
}

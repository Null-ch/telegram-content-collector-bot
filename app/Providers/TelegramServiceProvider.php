<?php

namespace App\Providers;

use App\Interfaces\TelegramServiceInterface;
use App\Services\MessageProcessorService;
use App\Services\TelegramService;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TelegramServiceInterface::class, TelegramService::class);
        $this->app->singleton(MessageProcessorService::class, function ($app) {
            return new MessageProcessorService($app->make(TelegramServiceInterface::class));
        });
    }

    public function boot(): void
    {
        //
    }
} 
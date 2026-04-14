<?php

namespace App\Providers;

use App\Interfaces\PollAnswerRepositoryInterface;
use App\Interfaces\PollOptionRepositoryInterface;
use App\Interfaces\PollRepositoryInterface;
use App\Repositories\PollAnswerRepository;
use App\Repositories\PollOptionRepository;
use App\Repositories\PollRepository;
use Illuminate\Support\ServiceProvider;

class AppBindingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(PollRepositoryInterface::class, PollRepository::class);
        $this->app->bind(PollAnswerRepositoryInterface::class, PollAnswerRepository::class);
        $this->app->bind(PollOptionRepositoryInterface::class, PollOptionRepository::class);
    }
}

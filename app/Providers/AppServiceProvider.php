<?php

namespace App\Providers;

use App\Repositories\Eloquent\RecordCategoryRepository;
use App\Repositories\Eloquent\RecordRepository;
use App\Repositories\Interfaces\RecordCategoryRepositoryInterface;
use App\Repositories\Interfaces\RecordRepositoryInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RecordCategoryRepositoryInterface::class, RecordCategoryRepository::class);
        $this->app->bind(RecordRepositoryInterface::class, RecordRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}

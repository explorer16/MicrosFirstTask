<?php

namespace App\Providers;

use App\Repositories\Eloquent\RecordCategoryRepository;
use App\Repositories\Interfaces\RecordCategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RecordCategoryRepositoryInterface::class, RecordCategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

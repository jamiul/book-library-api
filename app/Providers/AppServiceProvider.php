<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Interfaces\BookshelfRepositoryInterface',
            'App\Repositories\BookshelfRepository'
        );
        $this->app->bind(
            'App\Interfaces\BookRepositoryInterface',
            'App\Repositories\BookRepository'
        );
        $this->app->bind(
            'App\Interfaces\ChapterRepositoryInterface',
            'App\Repositories\ChapterRepository'
        );
        $this->app->bind(
            'App\Interfaces\PageRepositoryInterface',
            'App\Repositories\PageRepository'
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

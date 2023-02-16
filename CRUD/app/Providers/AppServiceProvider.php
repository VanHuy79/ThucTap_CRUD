<?php

namespace App\Providers;

// Post
use App\Service\File\FileService;
use App\Service\Post\PostService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\File\FileRepository;
use App\Repositories\Post\PostRepository;
use App\Service\File\FileServiceInterface;
use App\Service\Post\PostServiceInterface;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            PostRepositoryInterface::class,
            PostRepository::class
        );

        $this->app->singleton(
            PostServiceInterface::class,
            PostService::class,
        );
        $this->app->singleton(
            FileRepositoryInterface::class,
            FileRepository::class
        );

        $this->app->singleton(
            FileServiceInterface::class,
            FileService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}

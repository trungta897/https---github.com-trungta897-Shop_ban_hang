<?php

namespace App\Providers;

use App\Repositories\Product\ProductRepositoryInterFace;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductComment\ProductCommentRepositoryInterFace;
use App\Repositories\ProductComment\ProductCommentRepository;

use App\Service\Product\ProductServiceInterFace;
use App\Service\Product\ProductService;

use App\Service\ProductComment\ProductCommentServiceInterFace;
use App\Service\ProductComment\ProductCommentService;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Products
        $this->app->singleton(
            ProductRepositoryInterFace::class,
            ProductRepository::class
        );

        $this->app->singleton(
            ProductServiceInterFace::class,
            ProductService::class
        );

        $this->app->singleton(
            ProductCommentRepositoryInterFace::class,
            ProductCommentRepository::class
        );

        $this->app->singleton(
            ProductCommentServiceInterFace::class,
            ProductCommentService::class
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

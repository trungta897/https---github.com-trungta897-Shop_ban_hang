<?php

namespace App\Providers;

use App\Repositories\Product\ProductRepositoryInterFace;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterFace;
use App\Repositories\ProductComment\ProductCommentRepositoryInterFace;
use App\Repositories\ProductComment\ProductCommentRepository;

use App\Service\Product\ProductServiceInterFace;
use App\Service\Product\ProductService;

use App\Service\ProductComment\ProductCommentServiceInterFace;
use App\Service\ProductComment\ProductCommentService;

use App\Service\ProductCategory\ProductCategoryServiceInterFace;
use App\Service\ProductCategoryService\ProductCategoryService;

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

        // Poduct comments
        $this->app->singleton(
            ProductCommentRepositoryInterFace::class,
            ProductCommentRepository::class
        );

        $this->app->singleton(
            ProductCommentServiceInterFace::class,
            ProductCommentService::class
        );

        // Product Category
        $this->app->singleton(
            ProductCategoryRepositoryInterFace::class,
            ProductCategoryRepository::class
        );

        $this->app->singleton(
            ProductCategoryServiceInterFace::class,
            ProductCategoryService::class
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

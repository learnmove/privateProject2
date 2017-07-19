<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoiceRepository::class, \App\Repositories\InvoiceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoiceItemRepository::class, \App\Repositories\InvoiceItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RankRepository::class, \App\Repositories\RankRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EvaluationRepository::class, \App\Repositories\EvaluationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RatingRepository::class, \App\Repositories\RatingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RatingCommentRepository::class, \App\Repositories\RatingCommentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductQuestionRepository::class, \App\Repositories\ProductQuestionRepositoryEloquent::class);
        //:end-bindings:
    }
}

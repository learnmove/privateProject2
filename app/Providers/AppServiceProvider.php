<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \Carbon\Carbon::setLocale('zh-TW');


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
            $this->app->register(RepositoryServiceProvider::class);

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \Request::macro('success', function ($msg, $data) {
            \Request::json([
                "success" => true,
                "msg" => $msg,
                "data" => $data
            ]);
        });

        \Request::macro('fail', function ($msg, $data) {
            \Request::json([
                "success" => false,
                "msg" => $msg,
            ]);
        });
    }
}

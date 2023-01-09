<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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

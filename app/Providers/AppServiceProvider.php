<?php

namespace App\Providers;

use App\Models\Inbound\InboundEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('inboundEmail', function ($value) {
            return inboundEmail::withTrashed()
                               ->where('id', $value)
                               ->first();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // 非開發環境時，url 的傳輸協定強制為 https
        if (env('APP_ENV') !== 'local' && env('APP_ENV') !== 'dev') {
            URL::forceScheme('https');
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Entities\Currency;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Navbar', \App\Services\Navbar::class);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('mst_currency') && Currency::exists()) {
            $list = Cache::remember('currency.list', 3600, function () {
                return Currency::orderBy('curr_code')
                    ->pluck('curr_desc', 'curr_code')
                    ->toArray();
            });

            config(['currency.list' => $list]);

            $default = Currency::where('isactive', 1)->value('curr_code');
            if ($default) {
                config(['currency.default' => $default]);
            }
        }
    }
}

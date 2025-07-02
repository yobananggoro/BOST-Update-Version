<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Modules\Opsi\Entities\OptionGroup;

class OptionServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('mst_option_group')) {
            $options = [];
            if (OptionGroup::count()) {
                $results = Cache::has('options') ?
                Cache::get('options') :
                Cache::remember('options', now()->addMinutes(15), function () {
                    return OptionGroup::all();
                });
 
                if ($results) {
                    foreach ($results as $result) {
                        $options[$result->name] = $result->optionValues->sortBy('sequence')
                            ->mapWithKeys(function ($item, $key) {
                                return [$item['key'] => $item['value']];
                            })
                            ->toArray();
                    }

                    foreach ($options as $key => $value) {
                        \Illuminate\Support\Facades\View::share($key, $value);
                        \Illuminate\Support\Facades\Config::set('options.' . $key, $value);
                    }
                }
            }
        }

        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('app_cutoff') && \Modules\CutOff\Entities\CutOff::count()) {
            \Illuminate\Support\Facades\View::share('cutoff_notif', closest_cutoff());
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;

class ConfigServiceProvider extends \Illuminate\Support\ServiceProvider
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
        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('mst_configuration')) { //Ubah disini mst_configuration_local || mst_configuration "Dev or Prod"
            Cache::forget('configurations');
            $configurations = Cache::has('configurations') ? Cache::get('configurations') :
                Cache::rememberForever('configurations', function () { return \App\Entities\Configuration::all(); }); //Ubah disini ConfigurationLocal || Configuration "Dev or Prod"

            foreach ($configurations as $configuration) {
                $value = !in_array($configuration->value, ['true', 'false']) ? $configuration->value : $configuration->value === 'true';

                if ($configuration->component === 'database') {
                    $value = collect(json_decode($value, true))->mapWithKeys(function ($item) {
                        return [
                            $item['name'] => [
                                'driver' => $item['driver'], 'host' => $item['host'], 'port' => $item['port'],
                                'database' => $item['database'], 'username' => $item['username'], 'password' => $item['password'],
                                'charset' => ($item['driver'] === 'mysql' ? 'utf8mb4' : 'utf8'), 'prefix' => '',
                                'prefix_indexes' => true,
                            ]
                        ];
                    })->toArray();
                }

                \Illuminate\Support\Facades\Config::set($configuration->component . '.' . $configuration->key, $value);
            }
        }
    }
}

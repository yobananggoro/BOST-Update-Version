<?php

namespace Modules\Dashboard\Providers;

class AppServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var string
     */
    protected $viewNamespace = 'dashboard';

    public function boot()
    {
        $this->registerViews();
        $this->loadMigrationsFrom(app_path('Modules\Dashboard\database\migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function registerViews()
    {
        $sourcePath = __DIR__ . '/../views';

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/' . $this->viewNamespace;
        }, \Config::get('view.paths')), [$sourcePath]), $this->viewNamespace);
    }
}

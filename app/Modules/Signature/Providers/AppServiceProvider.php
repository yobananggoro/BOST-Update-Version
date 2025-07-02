<?php

namespace Modules\Signature\Providers;

class AppServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var string
     */
    protected $viewNamespace = 'signature';

    public function boot()
    {
        $this->registerViews();
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

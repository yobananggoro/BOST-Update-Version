<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Collective\Html\HtmlBuilder;
use App\Entities\Currency;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

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
        // dd('a');
        if (Schema::hasTable('mst_currency') && Currency::exists()) {
            $list = Cache::remember('currency.list', 3600, function () {
                return Currency::orderBy('curr_code')
                    ->pluck('curr_desc', 'curr_code')
                    ->toArray();
            });

            config(['currency.list' => $list]);

            $default = Cache::remember('currency.default', 3600, function () {
                return Currency::where('isactive', 1)->where('curr_code', 'IDR')->value('curr_code');
            });

            if ($default) {
                config(['currency.default' => $default]);
            } //dd($list,$default);
        }

        // Update for laravel 8
        Paginator::useBootstrap();

        // Update for laravel 11
        // 1. MACRO SEBELUMNYA (linkUpdateDelete)
        HtmlBuilder::macro('linkUpdateDelete', function (string $uri, $parameter) {
            if (auth()->user()->can('edit ' . $uri) || auth()->user()->can('destroy ' . $uri)) {
                $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';

                if (auth()->user()->can('edit ' . $uri)) {
                    $html .= '<a href="' . route($uri . '.edit', $parameter['id']) . '" class="dropdown-item" rel="action" title="' . __('label.update_message', ['label' => $parameter['label']]) . '">' . __('label.update_message', ['label' => $parameter['label']]) . '</a>';
                }

                if (auth()->user()->can('destroy ' . $uri)) {
                    $html .= '<a href="' . route($uri . '.destroy', $parameter['id']) . '" class="dropdown-item" rel="delete" title="' . __('label.delete_message', ['label' => $parameter['label']]) . '">' . __('label.delete_message', ['label' => $parameter['label']]) . '</a>';
                }

                $html .= '</div></button>';

                return new \Illuminate\Support\HtmlString($html);
            }

            return __('label.no_action');
        });

        // 2. MACRO BARU (linkCreate)
        HtmlBuilder::macro('linkCreate', function (string $uri, array $attributes = null, array $parameter = null) {
            if (auth()->user()->can('create ' . $uri)) {
                // Di dalam Macro, panggil attribute generator menggunakan $this->attributes()
                $html = '<a href="' . route($uri . '.create', $parameter) . '" class="btn btn-success" rel="page-content" ' . $this->attributes($attributes) . '><i class="fa fa-plus"></i> ' . __('label.create') . '</a>';

                return new \Illuminate\Support\HtmlString($html);
            }

            return '';
        });

        // 3. MACRO BARU: linkActions
        HtmlBuilder::macro('linkActions', function (array $actions, $parameter) {
            $can = 0;
            $link = '';

            foreach ($actions as $action) {
                // Penyesuaian: Menggunakan helper url(), route(), dan action() global Laravel
                if (Str::contains($action['url'], '.')) {
                    $url = route($action['url'], $parameter);
                } elseif (Str::contains($action['url'], '@')) {
                    $url = action($action['url'], $parameter);
                } else {
                    $url = url($action['url'], $parameter);
                }

                if (isset($action['attributes']['class'])) {
                    $action['attributes']['class'] = $action['attributes']['class'] . ' dropdown-item';
                } else {
                    $action['attributes']['class'] = 'dropdown-item';
                }

                if (auth()->user()->can($action['permission'])) {
                    $link .= '<a href="' . $url . '" ' . $this->attributes($action['attributes']) . '>' . $action['label'] . '</a>';
                    ++$can;
                }
            }

            if ($can > 0) {
                $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';
                $html .= $link;
                $html .= '</div></button>';

                return new HtmlString($html);
            }

            return __('label.no_action');
        });
    }
}

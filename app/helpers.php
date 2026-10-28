<?php

if (!function_exists('to_lower')) {
    /**
     * @param string $str
     * @return string
     */
    function to_lower(string $str)
    {
        return strtolower($str);
    }
}

if (!function_exists('to_upper')) {
    /**
     * @param string $str
     * @return string
     */
    function to_upper(string $str)
    {
        return strtoupper($str);
    }
}

if (!function_exists('to_camel')) {
    /**
     * @param string $str
     * @return string
     */
    function to_camel(string $str)
    {
        $par = strtolower($str);
        $str = ucwords($par);

        return $str;
    }
}

if (!function_exists('to_dropdown')) {
    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $collections
     * @param string $key
     * @param string|array $value
     * @param bool $blank_option
     * @return array
     */
    function to_dropdown($collections, string $key = 'id', $value = 'name', bool $blank_option = true)
    {
        $options = [];

        if ($blank_option) {
            $options[''] = trans('label.choose_one');
        }

        if (!is_array($collections)) {
            foreach ($collections as $collection) {
                if (is_array($value)) {
                    $tempValue = [];

                    foreach ($value as $val) {
                        $tempValue[] = $collection->$val;
                    }

                    $options[$collection->$key] = implode(' - ', $tempValue);
                } else {
                    $options[$collection->$key] = $collection->$value;
                }
            }
        } else {
            foreach ($collections as $key => $value) {
                $options[$key] = $value;
            }
        }

        return $options;
    }
}

if (!function_exists('to_check_radio')) {
    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $collections
     * @param string $key
     * @param string $value
     * @return array
     */
    function to_check_radio($collections, string $key = 'id', string $value = 'name')
    {
        $options = [];

        if (is_array($collections)) {
            $collections = collect($collections);
        }

        foreach ($collections as $collection) {
            $options[$collection->$key] = $collection->$value;
        }

        return $options;
    }
}

if (!function_exists('format_date')) {
    /**
     * @param string $date
     * @param string $format
     * @param string|null $locale
     * @return string
     * @throws Exception
     */
    function format_date(string $date, string $format = '%A, %e %B %Y', ?string $locale = null)
    {
        if (!is_null($date)) {
            $locale = !is_null($locale) ? $locale : config('app.locale');
            setlocale(LC_TIME, $locale);

            if ($date instanceof \Carbon\Carbon) {
                return $date->formatLocalized($format);
            }

            return (new \Carbon\Carbon($date))->formatLocalized($format);
        }

        return '-';
    }
}

if (!function_exists('format_date_short')) {
    /**
     * @param string $date
     * @param string $format
     * @param string|null $locale
     * @return string
     * @throws Exception
     */
    function format_date_short(string $date, string $format = '%d %B %Y', ?string $locale = null)
    {
        if (!is_null($date)) {
            $locale = !is_null($locale) ? $locale : config('app.locale');
            setlocale(LC_TIME, $locale);

            if ($date instanceof \Carbon\Carbon) {
                return $date->formatLocalized($format);
            }

            return (new \Carbon\Carbon($date))->formatLocalized($format);
        }

        return '-';
    }
}

if (!function_exists('option_values')) {
    /**
     * @param string $name
     * @param bool $as_dropdown
     * @return array|null
     */
    function option_values(string $name, bool $as_dropdown = false)
    {
        if (\Modules\Opsi\Entities\OptionGroup::count()) {
            $results = \Modules\Opsi\Entities\OptionGroup::where('name', $name)->first()->optionValues;

            return ($as_dropdown ? to_dropdown($results, 'key', 'value') : $results);
        }

        return null;
    }
}

if (!function_exists('map_root_uri')) {
    /**
     * @return array
     */
    function map_root_uri()
    {
        $uri = [];
        $excluded_uris = ['/', 'home', 'login', 'logout'];

        foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
            if ($route->getPrefix() !== 'api' && !in_array($route->uri(), $excluded_uris) && $route->methods()[0] === 'GET') {
                if ($route->getName()) {
                    list($r, $a) = explode('.', $route->getName());

                    if ($a === 'index')
                        $uri[] = $r;
                } else {
                    $uri[] = $route->uri();
                }
            }
        }

        return $uri;
    }
}

if (!function_exists('map_action_uri')) {
    /**
     * @param bool $with_controller
     * @return array
     */
    function map_action_uri(bool $with_controller = false)
    {
        $uri = [];
        $excluded_uris = ['/', 'home', 'login', 'logout', '_ignition/health-check', '_ignition/scripts/{script}', '_ignition/styles/{style}'];

        foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
            if ($route->getPrefix() !== 'api' && !in_array($route->uri(), $excluded_uris) && in_array($route->methods()[0], ['GET', 'DELETE'])) {
                if ($route->getName() && \Illuminate\Support\Str::contains($route->getName(), '.')) {
                    list($r, $a) = explode('.', $route->getName());

                    if ($a !== 'index') {
                        if ($with_controller) {
                            $uri[$r][] = $a . ' ' . $r;
                        } else {
                            $uri[] = $a . ' ' . $r;
                        }
                    }
                } else {
                    if ($with_controller) {
                        $uri[$route->getName()][] = $route->uri();
                    } else {
                        $uri[] = $route->uri();
                    }
                }
            }
        }

        return $uri;
    }
}

if (!function_exists('permitRolesByUri')) {
    /**
     * @param string $uri
     * @return string
     */
    function permitRolesByUri(string $uri): string
    {
        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('mst_role_has_module')) {
            $result = \Illuminate\Support\Facades\DB::table('mst_role_has_module')
                ->select('mst_role.name')
                ->join('mst_module', 'mst_role_has_module.module_id', '=', 'mst_module.id')
                ->join('mst_role', 'mst_role_has_module.role_id', '=', 'mst_role.id')
                ->where('mst_module.uri', $uri)
                ->get();

            return ($result ? $result->implode('name', '|') : '');
        }

        return '';
    }
}

if (!function_exists('forPermissions')) {
    /**
     * @return array
     */
    function forPermissions(): array
    {
        $actions = map_action_uri(true);
        $modules = \App\Entities\Module::permissions();

        return [
            'actions' => $actions,
            'modules' => $modules,
            'permissions' => collect($actions)->only($modules->pluck('uri'))->toArray(),
            'additionals' => collect($actions)
                ->except(array_merge($modules->pluck('uri')->toArray(), ['', 'register', 'password', 'verification', 'profile']))
                ->flatten()->toArray(),
        ];
    }
}

if (!function_exists('hasModulePermission')) {
    /**
     * @param string $module
     * @return bool
     */
    function hasModulePermission(string $module): bool
    {

        $i = 0;
        $permissions = auth()->guard()->user()->permissions->map(function ($item) use ($module) {
            return \Illuminate\Support\Str::contains($item, $module) ? $item : null;
        });

        // dd($permissions);

        foreach ($permissions as $permission) {
            if (!is_null($permission)) {
                ++$i;
            }
        }

        return $i > 0;
    }
}

if (!function_exists('isHome')) {
    /**
     * @return string
     */
    function isHome()
    {
        $uri = request()->getUri();

        return \Illuminate\Support\Str::contains($uri, 'home') ||
            $uri === str_replace(request()->getScheme() . '::', '', config('app.url')) ? 'active' : '';
    }
}

if (!function_exists('monthName')) {
    /**
     * @param int $month
     * @param string $format
     * @param string|null $locale
     * @return string
     */
    function monthName(int $month, string $format = '%B', ?string $locale = null)
    {
        $locale = !is_null($locale) ? $locale : config('app.locale');
        setlocale(LC_TIME, $locale);

        return \Carbon\Carbon::create(null, $month)->formatLocalized($format);
    }
}

if (!function_exists('numberToRoman')) {
    /**
     * @param int $number
     * @return string
     */
    function numberToRoman(int $number)
    {
        return \Riskihajar\Terbilang\Facades\Terbilang::roman($number);
    }
}

// if (!function_exists('terbilang')) {
//     /**
//     * @param int $number
//     * @param string|null $prefix
//     * @param string|null $suffix
//     * @return mixed
//     */
//     function terbilang(int $number, string $prefix = null, string $suffix = null)
//     {
//         return \Illuminate\Support\Str::title(\Riskihajar\Terbilang\Facades\Terbilang::make($number, $prefix, $suffix));
//     }
// }

if (!function_exists('terbilang')) {
    /**
     * Konversi angka menjadi teks terbilang (termasuk sen jika ada)
     *
     * @param float|int|string $number
     * @param string|null $prefix
     * @param string|null $suffix
     * @param string|null $currencyCode
     * @return string
     */
    function terbilang($number, ?string $prefix = null, ?string $suffix = null, ?string $currencyCode = null)
    {
        // Pastikan angka dalam format float
        $number = (float) $number;

        // Pisahkan bagian utama dan desimal
        $integerPart = floor($number);
        $decimalPart = round(($number - $integerPart) * 100); // dua digit sen

        // Buat terbilang untuk bagian utama
        $text = \Illuminate\Support\Str::title(
            \Riskihajar\Terbilang\Facades\Terbilang::make($integerPart, $prefix, $suffix)
        );

        // Ambil label currency dari config (misal: "Rupiah")
        $currencyLabel = $currencyCode
            ? config('currency.list.' . strtoupper($currencyCode), $currencyCode)
            : '';

        // Jika ada bagian sen
        if ($decimalPart > 0) {
            $senText = \Illuminate\Support\Str::title(
                \Riskihajar\Terbilang\Facades\Terbilang::make($decimalPart)
            );
            return trim("{$text} {$currencyLabel} dan {$senText} Sen");
        }

        return trim("{$text} {$currencyLabel}");
    }
}


if (!function_exists('mask_string')) {
    function mask_string($value, $slice = 4): string
    {
        $len = strlen($value) - $slice;
        $mask = str_repeat('*', $len) . substr($value, $len);

        return $mask;
    }
}

if (!function_exists('excludeKeys')) {
    function excludeKeys(array $array, array $keysToExclude): array
    {
        return array_diff_key($array, array_flip($keysToExclude));
    }
}

if (!function_exists('adminRoles')) {
    function adminRoles()
    {
        return \Illuminate\Support\Facades\Cache::remember('admin_roles', 3600, function () {
            return Modules\User\Entities\Role::where('is_admin', true)
                ->pluck('name')
                ->toArray();
        });
    }
}

if (!function_exists('transactionRoles')) {
    function transactionRoles()
    {
        return \Illuminate\Support\Facades\Cache::remember('transaction_roles', 3600, function () {
            return Modules\User\Entities\Role::where('is_transactions', true)
                ->pluck('name')
                ->toArray();
        });
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PermissionsTablesSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $userTable = 'app_user';

    /**
     * @var string
     */
    protected $moduleTable = 'mst_module';

    /**
     * @var string
     */
    protected $roleTable = 'mst_role';

    /**
     * @var string
     */
    protected $permissionTable = 'mst_permission';

    /**
     * @var string
     */
    protected $roleHasModuleTable = 'mst_role_has_module';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->userTable)->delete();
        DB::table($this->moduleTable)->delete();
        DB::table($this->roleTable)->delete();
        DB::table($this->permissionTable)->truncate();

        $now = now();
        $modules = [
            [
                'label' => 'Hak Akses', 'uri' => 'hak-akses', 'icon' => 'fa fa-key', 'parent_module' => null,
                'visible' => 't', 'sequence' => '1', 'childs' => [],
            ],
            [
                'label' => 'Opsi', 'uri' => 'opsi', 'icon' => 'fa fa-bars', 'parent_module' => null,
                'visible' => 't', 'sequence' => '2', 'childs' => [],
            ],
            [
                'label' => 'Log', 'uri' => '#', 'icon' => 'fa fa-rss-square', 'parent_module' => null,
                'visible' => 't', 'sequence' => '3', 'childs' => [
                    [
                        'label' => 'Log Aktifitas', 'uri' => 'log-aktifitas', 'icon' => 'fa fa-paw',
                        'visible' => 't', 'sequence' => '3.1', 'childs' => [],
                    ],
                    [
                        'label' => 'Log Aplikasi', 'uri' => 'log-aplikasi', 'icon' => 'fa fa-laptop',
                        'visible' => 't', 'sequence' => '3.2', 'childs' => [],
                    ],
                ]
            ],
            [
                'label' => 'Setting', 'uri' => 'setting', 'icon' => 'fa fa-cogs', 'parent_module' => null,
                'visible' => 't', 'sequence' => '4', 'childs' => [],
            ],
            [
                'label' => 'Menu', 'uri' => 'menu', 'icon' => 'fa fa-menu', 'parent_module' => null,
                'visible' => 't', 'sequence' => '5', 'childs' => [],
            ],
            [
                'label' => 'User Management', 'uri' => 'users', 'icon' => 'fa fa-users', 'parent_module' => null,
                'visible' => 't', 'sequence' => '6', 'childs' => [],
            ],
            [
                'label' => 'Master', 'uri' => '#', 'icon' => 'fa fa-solid fa-sitemap', 'parent_module' => null,
                'visible' => 't', 'sequence' => '7', 'childs' => [
                    [
                        'label' => 'Rekening', 'uri' => 'rekening', 'icon' => 'fa fa-light fa-address-book',
                        'visible' => 't', 'sequence' => '7.1', 'childs' => [],
                    ],
                    [
                        'label' => 'Otorisasi Tree', 'uri' => 'otorisasi-tree', 'icon' => 'fa fa-user-secret',
                        'visible' => 't', 'sequence' => '7.2', 'childs' => [],
                    ],
                    [
                        'label' => 'Email Simba', 'uri' => 'email-simba', 'icon' => 'fa fa-light fa-address-book',
                        'visible' => 't', 'sequence' => '7.3', 'childs' => [],
                    ],
                    [
                        'label' => 'Reload Id ATM', 'uri' => 'reload-id-atm', 'icon' => 'fa fa-credit-card',
                        'visible' => 't', 'sequence' => '7.4', 'childs' => [],
                    ],
                ]
            ],
            [
                'label' => 'Account', 'uri' => '#', 'icon' => 'fa fa-book', 'parent_module' => null,
                'visible' => 't', 'sequence' => '8', 'childs' => [
                    [
                        'label' => 'Account Balance [AB]', 'uri' => 'account-balance', 'icon' => 'fa fa-file-invoice',
                        'visible' => 't', 'sequence' => '8.1', 'childs' => [],
                    ],
                    [
                        'label' => 'Account - PROMPT', 'uri' => 'account-gi', 'icon' => 'fa fa-file-invoice',
                        'visible' => 't', 'sequence' => '8.2', 'childs' => [],
                    ],
                ]
            ],
            [
                'label' => 'Pemindahbukuan', 'uri' => '#', 'icon' => 'fa fa-retweet', 'parent_module' => null,
                'visible' => 't', 'sequence' => '9', 'childs' => [
                    [
                        'label' => 'One to One [ITA]', 'uri' => 'pemindahbukuan-ita', 'icon' => 'fa fa-cubes',
                        'visible' => 't', 'sequence' => '9.1', 'childs' => [],
                    ],
                    [
                        'label' => 'One to Many [AGI]', 'uri' => 'pemindahbukuan-agi', 'icon' => 'fa fa-cubes',
                        'visible' => 't', 'sequence' => '9.2', 'childs' => [],
                    ],
                    [
                        'label' => 'Transaksi List', 'uri' => 'transaksi-pemindahbukuan', 'icon' => 'fas fa-list-alt',
                        'visible' => 't', 'sequence' => '9.3', 'childs' => [],
                    ],
                    [
                        'label' => 'Remote Otorisasi', 'uri' => 'remote-otorisasi', 'icon' => 'fa fa-check-square',
                        'visible' => 't', 'sequence' => '9.4', 'childs' => [],
                    ],
                    [
                        'label' => 'Report Transaksi', 'uri' => 'report-transaksi', 'icon' => 'fa fa-report',
                        'visible' => 't', 'sequence' => '9.5', 'childs' => [],
                    ],
                ]
            ],
        ];

        foreach ($modules as $module) {
            $childs = $module['childs'];
            unset($module['childs']);
            \App\Entities\Module::create($module);

            if (!empty($childs)) {
                $moduleId = \App\Entities\Module::findByLabel($module['label']);

                foreach ($childs as $child) {
                    unset($child['childs']);
                    $child['parent_module'] = $moduleId->id;
                    \App\Entities\Module::create($child);
                }
            }
        }

        (new \Modules\HakAkses\Imports\RoleImport)->import('imports/Role.xlsx');
        $permissions = array_merge(map_action_uri(), [
            
        ]);

        foreach ($permissions as $permission) {
            if (!in_array($permission, ['verify verification', 'login', 'request password', 'reset password', 'register'])) {
                DB::table($this->permissionTable)->insert([
                    'name' => $permission, 'guard_name' => 'web',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        $modules = \App\Entities\Module::orderBy('sequence')->get();
        $roles = \Modules\HakAkses\Entities\Role::all();
        $permissions = \Modules\HakAkses\Entities\Permission::all();
        \Illuminate\Support\Facades\Artisan::call('permission:cache-reset');

        foreach ($roles as $role) {
            if ($role->name == 'SUPER ADMIN') {
                $modules->each(function ($module, $key) use ($role, $permissions) {
                    DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                    $role->givePermissionTo($permissions->pluck('name')->toArray());
                });
            } else if ($role->name == 'OMD') {
                $modules->whereIn('label', ['Log', 'Log Aktifitas', 'Log Aplikasi', 'Setting'])
                    ->each(function ($module, $key) use ($role, $permissions) {
                        DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                        $permissions = $permissions->map(function ($permission, $key) use ($module) {
                        if (Str::contains($permission['name'], $module['uri']) && $permission['name'] !== 'clean log-aktifitas') {
                                return $permission;
                            }
                        });
                        $role->givePermissionTo($permissions->pluck('name')->toArray());
                    });
            } else if ($role->name == 'IT SECURITY') {
                $modules->whereIn('label', ['Hak Akses', 'Log', 'Log Aktifitas'])
                    ->each(function ($module, $key) use ($role, $permissions) {
                        DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                        $permissions = $permissions->map(function ($permission, $key) use ($module) {
                        if (Str::contains($permission['name'], $module['uri']) && $permission['name'] !== 'clean log-aktifitas') {
                                return $permission;
                            }
                        });
                        $role->givePermissionTo($permissions->pluck('name')->toArray());
                    });
            } else if ($role->name == 'USER') {
                $modules->whereIn('label', ['Hak Akses', 'Log', 'Log Aktifitas'])
                    ->each(function ($module, $key) use ($role, $permissions) {
                        DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                        $permissions = $permissions->map(function ($permission, $key) use ($module) {
                        if (Str::contains($permission['name'], $module['uri']) && $permission['name'] !== 'clean log-aktifitas') {
                                return $permission;
                            }
                        });
                        $role->givePermissionTo($permissions->pluck('name')->toArray());
                    });
            } else if ($role->name == 'SPV') {
                $modules->whereIn('label', ['Hak Akses', 'Log', 'Log Aktifitas'])
                    ->each(function ($module, $key) use ($role, $permissions) {
                        DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                        $permissions = $permissions->map(function ($permission, $key) use ($module) {
                        if (Str::contains($permission['name'], $module['uri']) && $permission['name'] !== 'clean log-aktifitas') {
                                return $permission;
                            }
                        });
                        $role->givePermissionTo($permissions->pluck('name')->toArray());
                    });
            }
        }

        if (app()->environment(['local', 'development'])) {
            (new \Modules\User\Imports\UserImport)->import('imports/User.xlsx');
        }
    }
}

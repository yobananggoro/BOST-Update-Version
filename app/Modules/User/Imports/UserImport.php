<?php

namespace Modules\User\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\HakAkses\Entities\Role;
use Modules\User\Entities\User;

class UserImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $now = now();

        foreach ($collection as $collect) {
            \Illuminate\Support\Facades\DB::table('app_user')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'username' => $collect['username'],
                'password' => bcrypt('p@ssw0rd'),
                'email' => $collect['email'],
                'status' => 1,
            ]);

            $user = User::findByUsername($collect['username']);
            $role = Role::findById($collect['role_id']);
            $user->profile()->insert([
                'user_id' => $user->id,
                'nama' => to_upper($collect['nama']),
                'nip' => $collect['nip'],
                'hp' => $collect['hp'],
                'unit_kerja_kode' => $collect['unit_kerja_kode'],
            ]);
            $user->assignRole($role->name);
            $user->syncPermissions($role->permissions->pluck('name')->toArray());
        }
    }
}

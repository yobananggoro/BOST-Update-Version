<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaTableSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $table = 'app_unit_kerja';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        (new \App\Imports\UnitKerjaImport)->import('imports/UnitKerja.xlsx');
    }
}

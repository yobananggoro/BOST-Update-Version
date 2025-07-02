<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigurationTableSeeder::class);
        $this->call(OptionTablesSeeder::class);
        $this->call(UnitKerjaTableSeeder::class);
        $this->call(PermissionsTablesSeeder::class);

        // if (app()->environment(['local', 'development'])) {
        //     $this->call(DummyTablesSeeder::class);
        // }
    }
}

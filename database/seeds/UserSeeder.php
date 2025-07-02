<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_user')->insert(
            [
                'id'=> uuid::uuid4(),
                'username' => 'ADM1',
                'email' => null,
                'password' => Hash::make('p@ssw0rd'),
                'status' => 1
            ]
        );
    }
}

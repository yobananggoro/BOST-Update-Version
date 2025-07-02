<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TransaksiSeeder extends Seeder
{

    /**
     * @var string
     */
    protected $transaksi = 'app_transaction';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $tanggal = Carbon::now()->format('d-m-Y');
 
    	for($i = 1; $i <= 10000; $i++){
    		DB::table($this->transaksi)->insert([
                [
                'id'=> uuid::uuid4(),
    			'tipe_transaksi' => $faker->numberBetween(1,2),
    			'reff' => '0001L116'.str_pad($faker->numberBetween(128, 1000), 4, '0', STR_PAD_LEFT),
    			// 'tanggal' => $faker->dateTime()->format('d-m-Y'),
                'tanggal' => $faker->dateTimeInInterval($startDate = '-7 days', $endDate = 'now', $timezone = null)->format('Y-m-d'),
    			'nominal' => $faker->numberBetween(10000000,900000000),
                'userid' => 'L116',
                'user_override' => 'L114',
                'branch' => '0001',
                'additional_info' => null,
                'status_override' => 1,
                'status_transaksi' => 1,
                'response_http' => 'json',
                'response_message' => 'json',
                ],
    		]);
    	}
    }
}

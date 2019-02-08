<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert($this->getOrders());
    }

    private function getOrders() : array
    {
        $buff = [];

        $statuses = [
            'CANCELED',
            'USER_CANCELED',
            'ESHOP',
            'SUCCESS',
            'PARTIAL_SUCCESS',
            'FAILURE',
            'IN_PROGRESS',
            'NOT_PROCESSED',
            'ACCEPTED'
        ];

        for ($i = 0; $i < 300; $i++) {
            $buff[] = [
                'status' => $statuses[rand(0, 8)],
                'created_at' => Carbon::create(date('Y'), rand(1, 12), rand(1, 28)),
                'total_price' => rand(50, 1000)
            ];
        }

        return $buff;
    }
}

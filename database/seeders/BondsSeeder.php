<?php

namespace Database\Seeders;

use App\Models\Bond;
use Illuminate\Database\Seeder;

class BondsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bonds = [
            [
                'issue_date'=>'2021-11-08',
                'last_turnover_date'=> '2022-11-03',
                'nominal_price'=> 100,
                'payment_frequency'=> '4',
                'calculating_period'=> '360',
                'coupon_interest'=> 10,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'issue_date'=>'2021-11-08',
                'last_turnover_date'=> '2022-11-07',
                'nominal_price'=> 200,
                'payment_frequency'=> '4',
                'calculating_period'=> '364',
                'coupon_interest'=> 20,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ],
            [
                'issue_date'=>'2021-11-08',
                'last_turnover_date'=> '2022-11-08',
                'nominal_price'=> 300,
                'payment_frequency'=> '4',
                'calculating_period'=> '365',
                'coupon_interest'=> 30,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]
        ];

        Bond::insert($bonds);
    }
}

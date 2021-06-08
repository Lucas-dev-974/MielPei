<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'client_id' => 1,
                'cultur_coordinate' => json_encode(['coordinate' => ["x" => '15484848', "y" => '88484848']]),
                'shop_name'     => 'Le miel réunion',
            ],
            [
                'client_id' => 2,
                'cultur_coordinate' => json_encode(['coordinate' => ["x" => '15484848', "y" => '88484848']]),
                'shop_name'     => 'honey shop 974 ',
            ]
        ];
        DB::table('vendors')->insert($data);
    }
}

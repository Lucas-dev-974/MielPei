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
                'shop_name'     => 'Zot miel',
            ]
        ];
        // foreach(array(1,2,3,4) as $id){

        // }
        DB::table('vendors')->insert($data);
    }
}

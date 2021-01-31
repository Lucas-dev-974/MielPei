<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeds extends Seeder
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
                'vendor_id' => 1,
                'price' => 9.50,
                'shop_name'     => 'Zot miel',
            ]
        ];

        DB::table('products')->insert($data);
        
    }
}

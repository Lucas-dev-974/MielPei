<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class attributionSeeder extends Seeder
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
                'id_client' => 1,
                'id_ordi' => 1,
                'horraire' => '8',
                'date' => date('Y-m-d'),
            ],
        ];
        
        DB::table('attributions')->insert($data);
    }
}

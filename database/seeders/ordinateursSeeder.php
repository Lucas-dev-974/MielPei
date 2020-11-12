<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ordinateursSeeder extends Seeder
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
                'nom' => 'ordi 1',
            ],
            [
                'nom' => 'ordi 2',
            ],
            [
                'nom' => 'ordi 3',
            ]
        ];
        
        DB::table('ordinateurs')->insert($data);
    }
}

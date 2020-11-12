<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class clientsSeeder extends Seeder
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
                'nom' => 'client 1',
                'prenom' => 'C1'
            ],
            [
                'nom' => 'client 2',
                'prenom' => 'C2'
            ],
            [
                'nom' => 'client 3',
                'prenom' => 'C3'
            ],
        ];
        DB::table('clients')->insert($data);
    }
}

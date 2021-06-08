<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        $users_data = [
            'name' => ['lcs', 'marvin', 'chloe'],
            'last_name' => ['lvn', 'dupont', 'mounien'],
            'phone'     => ['06125496', '06125496', '06125496'],
            'role' => ['admin', 'user', 'vendor'],
        ];

        for($i = 0; $i < 3; $i++){
            $user = [
                'name' =>      $users_data['name'][$i],
                'last_name' => $users_data['last_name'][$i],
                'password'  => Hash::make($users_data['name'][$i] . $users_data['lastname'] .'@'),

            ];

            DB::table('users')->insert($user);
        }
        
    }
}

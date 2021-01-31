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
        $data = [
            [
                'name' => 'jason',
                'last_name' => 'hoareau',
                'email'     => 'jason.h@gmail.com',
                'password'  => Hash::make('jason.H@'),
                'phone'     => '06125496',
                'is_vendor' => false,
            ]
        ];

        DB::table('users')->insert($data);
    }
}

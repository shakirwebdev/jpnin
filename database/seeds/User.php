<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('users')->get()->count() == 0){

            DB::table('users')->insert([
                [
                    'user_id' => 1,
                    'no_ic' => '800519025403',
                    'user_email' => 'fairuz@rania.com.my',
                    'user_role' => 1,
                    'password' => Hash::make('kucingku'),
                    'user_status' => 1,
                    'remember_token' => Str::random(10),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]);

        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfile extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users profile is empty
        if(DB::table('users__profile')->get()->count() == 0){

            DB::table('users__profile')->insert([
                [
                    'user_id' => 1,
                    'user_id' => '1',
                    'user_fullname' => 'RANIA Developer',
                    'no_ic' => '800519025403',
                    'no_phone' => '0195599911',
                    'state_id' => '16',
                    'daerah_id' => '1601',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]);

        }
    }
}

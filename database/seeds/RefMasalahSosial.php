<?php

use Illuminate\Database\Seeder;

class RefMasalahSosial extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__masalah_sosial')->get()->count() == 0){
            DB::table('ref__masalah_sosial')->insert([
                [ 'id' => 1, 'sosial' => '1', 'sosial_description' => 'Lepak', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'sosial' => '2', 'sosial_description' => 'Perjudian', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'sosial' => '3', 'sosial_description' => 'Minum Arak / Samsu Haram', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'sosial' => '4', 'sosial_description' => 'Pelacuran', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'sosial' => '5', 'sosial_description' => 'Vandalisme', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'sosial' => '6', 'sosial_description' => 'Ponteng Sekolah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'sosial' => '7', 'sosial_description' => 'Lesbian Gay Biseksual Transgender', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'sosial' => '8', 'sosial_description' => 'Lumba Haram', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'sosial' => '9', 'sosial_description' => 'Sumbang Mahram', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'sosial' => '10', 'sosial_description' => 'Bohsia dan Bohjan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

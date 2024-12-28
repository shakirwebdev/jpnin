<?php

use Illuminate\Database\Seeder;

class RefJenisRumah extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__jenis_rumah')->get()->count() == 0){
            DB::table('ref__jenis_rumah')->insert([
                [ 'id' => 1, 'jenis_rumah' => '1', 'jenis_rumah_description' => 'Rumah Sebuah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'jenis_rumah' => '2', 'jenis_rumah_description' => 'Rumah Teres', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'jenis_rumah' => '3', 'jenis_rumah_description' => 'Rumah Kampung (Tradisional)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'jenis_rumah' => '4', 'jenis_rumah_description' => 'Setinggan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'jenis_rumah' => '5', 'jenis_rumah_description' => 'Rumah Berkembar (Semi-D)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'jenis_rumah' => '6', 'jenis_rumah_description' => 'Rumah Pangsa atau Flat', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'jenis_rumah' => '7', 'jenis_rumah_description' => 'Kondominium', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'jenis_rumah' => '8', 'jenis_rumah_description' => 'Apartment', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'jenis_rumah' => '9', 'jenis_rumah_description' => 'Rumah Kedai', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

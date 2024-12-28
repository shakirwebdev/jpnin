<?php

use Illuminate\Database\Seeder;

class Ref_Status_Perkahwinan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__status_perkahwinan')->get()->count() == 0){
            DB::table('ref__status_perkahwinan')->insert([
                [ 'id' => 1, 'perkahwinan_description' => 'Bujang', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'perkahwinan_description' => 'Berkahwin', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'perkahwinan_description' => 'Bercerai', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'perkahwinan_description' => 'Kematian Suami', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'perkahwinan_description' => 'Kematian Isteri', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

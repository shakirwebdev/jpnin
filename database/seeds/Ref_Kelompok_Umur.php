<?php

use Illuminate\Database\Seeder;

class Ref_Kelompok_Umur extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__kelompok_umur')->get()->count() == 0){
            DB::table('ref__kelompok_umur')->insert([
                [ 'id' => 1, 'umur_description' => '0 - 6', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'umur_description' => '7 - 12', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'umur_description' => '13 - 17', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'umur_description' => '18 - 35', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'umur_description' => '36 - 45', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'umur_description' => '45 - 59', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'umur_description' => '60 Keatas', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

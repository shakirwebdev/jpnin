<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Teras extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_teras')->get()->count() == 0){
            DB::table('ref__aktiviti_teras')->insert([
                [ 'id' => 1, 'teras_description' => 'Teras 1', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'teras_description' => 'Teras 2', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'teras_description' => 'Teras 3', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'teras_description' => 'Teras 4', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'teras_description' => 'Teras 5', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

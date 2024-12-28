<?php

use Illuminate\Database\Seeder;

class RefJenayah extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__jenayah')->get()->count() == 0){
            DB::table('ref__jenayah')->insert([
                [ 'id' => 1, 'jenayah' => '1', 'jenayah_description' => 'Pecah Rumah / Pecah Kenderaan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'jenayah' => '2', 'jenayah_description' => 'Ragut / Rompakan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'jenayah' => '3', 'jenayah_description' => 'Pengedaran / Penagihan Dadah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'jenayah' => '4', 'jenayah_description' => 'Pergaduhan / Gengster', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'jenayah' => '5', 'jenayah_description' => 'Lumba Haram', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

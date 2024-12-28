<?php

use Illuminate\Database\Seeder;

class Ref_Status_Rondaan_SRS extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__status_rondaan_srs')->get()->count() == 0){
            DB::table('ref__status_rondaan_srs')->insert([
                [ 'id' => 1, 'status_description' => 'Selesai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Belum Selesai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_description' => 'SRS Dibatalkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

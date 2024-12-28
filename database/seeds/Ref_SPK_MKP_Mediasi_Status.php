<?php

use Illuminate\Database\Seeder;

class Ref_SPK_MKP_Mediasi_Status extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__spk_mkp_mediasi_status')->get()->count() == 0){
            DB::table('ref__spk_mkp_mediasi_status')->insert([
                [ 'id' => 1, 'status_description' => 'Selesai', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Tidak Selesai', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}
<?php

use Illuminate\Database\Seeder;

class Ref_Status_SRS_Penarikan_Diri extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_srs_penarikan_diri')->get()->count() == 0){

            DB::table('ref__status_srs_penarikan_diri')->insert([
                [ 'id' => 1, 'status_description' => 'Disahkan Oleh PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Dihantar Untuk Pengesahan PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_description' => 'Ditolak Oleh PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);

        }
    }
}

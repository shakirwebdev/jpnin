<?php

use Illuminate\Database\Seeder;

class Ref_Status_SRS_Pembatalan_Srs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_srs_pembatalan_srs')->get()->count() == 0){

            DB::table('ref__status_srs_pembatalan_srs')->insert([
                [ 'id' => 1, 'status_description' => 'Diluluskan Oleh HQ SRS', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Belum Selesai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_description' => 'Dihantar Untuk Semakan PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'status_description' => 'Disemak Oleh PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'status_description' => 'Pengerusi Perlu Mengemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'status_description' => 'Disahkan Oleh PPN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'status_description' => 'PPD Perlu Mengemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'status_description' => 'PPN Perlu Mengemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);

        }
    }
}

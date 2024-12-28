<?php

use Illuminate\Database\Seeder;

class Ref_Status_SPK_Ikes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_spk_ikes')->get()->count() == 0){

            DB::table('ref__status_spk_ikes')->insert([
                [ 'id' => 1, 'status_description' => 'Disahkan Oleh P (PP)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Belum Selesai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_description' => 'Dimohon Oleh PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'status_description' => 'Diakui Oleh PPN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'status_description' => 'PPD Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'status_description' => 'Disemak Oleh BPP', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'status_description' => 'PPD Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'status_description' => 'PPD Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'status_description' => 'Dimohon Oleh PPN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'status_description' => 'Disemak Oleh BPP', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'status_description' => 'PPN Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'status_description' => 'PPN Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'status_description' => 'Dimohon Oleh BPP', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 14, 'status_description' => 'BPP Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 15, 'status_description' => 'BPP Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

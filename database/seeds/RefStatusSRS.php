<?php

use Illuminate\Database\Seeder;

class RefStatusSRS extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_srs')->get()->count() == 0){

            DB::table('ref__status_srs')->insert([
                [ 'id' => 1, 'status' => '1', 'status_description' => 'Aktif', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status' => '2', 'status_description' => 'Tidak Aktif', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status' => '3', 'status_description' => 'Kemaskini Profil SRS', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'status' => '4', 'status_description' => 'Memohon SRS', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'status' => '5', 'status_description' => 'Disemak Oleh PPD', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'status' => '6', 'status_description' => 'Pengerusi Perlu Mengemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'status' => '7', 'status_description' => 'Disahkan Oleh PPN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'status' => '8', 'status_description' => 'PPD Perlu Mengemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'status' => '9', 'status_description' => 'Diakui Oleh HQ JPNIN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'status' => '10', 'status_description' => 'PPN Perlu Mengemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

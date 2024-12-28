<?php

use Illuminate\Database\Seeder;

class Ref_Status_Krt_Projek_Ekonomi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_krt_projek_ekonomi')->get()->count() == 0){

            DB::table('ref__status_krt_projek_ekonomi')->insert([
                [ 'id' => 1, 'status_description' => 'Disahkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Dibatalkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_description' => 'Belum Selesai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'status_description' => 'Dihantar Untuk Disemak', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'status_description' => 'Setiausa Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'status_description' => 'Dihantar Untuk Disahkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'status_description' => 'Setiausa Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

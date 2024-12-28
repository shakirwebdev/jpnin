<?php

use Illuminate\Database\Seeder;

class Ref_Status_KRT_AJK_Luar extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_krt_ajk_luar')->get()->count() == 0){

            DB::table('ref__status_krt_ajk_luar')->insert([
                [ 'id' => 1, 'status_description' => 'Dihantar Untuk Pengesahan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Disahkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_description' => 'Perlu Kemaskini', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

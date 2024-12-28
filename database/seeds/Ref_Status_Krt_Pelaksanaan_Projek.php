<?php

use Illuminate\Database\Seeder;

class Ref_Status_Krt_Pelaksanaan_Projek extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_krt_pelaksanaan_projek')->get()->count() == 0){

            DB::table('ref__status_krt_pelaksanaan_projek')->insert([
                [ 'id' => 1, 'status_description' => 'Belum Dilaksanakan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_description' => 'Sedang Dilaksanakan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

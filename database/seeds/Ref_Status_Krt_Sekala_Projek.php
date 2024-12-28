<?php

use Illuminate\Database\Seeder;

class Ref_Status_Krt_Sekala_Projek extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_krt_sekala_projek')->get()->count() == 0){

            DB::table('ref__status_krt_sekala_projek')->insert([
                [ 'id' => 1, 'sekala_description' => 'Kecil (Pendapatan RM1000 ke bawah)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'sekala_description' => 'Sederhana (Pendapatan RM1000 - RM 3000)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'sekala_description' => 'Besar (Pendapatan RM3000 ke atas)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

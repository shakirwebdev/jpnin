<?php

use Illuminate\Database\Seeder;

class Ref_Status_Pekerjaan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__status_pekerjaan')->get()->count() == 0){
            DB::table('ref__status_pekerjaan')->insert([
                [ 'id' => 1, 'pekerjaan_description' => 'Bekerja', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'pekerjaan_description' => 'Tidak Bekerja', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'pekerjaan_description' => 'Belajar', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

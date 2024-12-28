<?php

use Illuminate\Database\Seeder;

class Ref_Krt_Tujuan_Pembatalan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__krt_tujuan_pembatalan')->get()->count() == 0){

            DB::table('ref__krt_tujuan_pembatalan')->insert([
                [ 'id' => 1, 'tujuan_description' => 'Persempadanan semula kawasan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'tujuan_description' => 'Penambahan semula KRT', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'tujuan_description' => 'Pembangunan Semula Kawasan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'tujuan_description' => 'Pembatalan terus disebabkan tidak dapat diaktifkan semula', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'tujuan_description' => 'Lain-lain : Nyatakan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

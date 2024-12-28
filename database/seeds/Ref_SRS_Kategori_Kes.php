<?php

use Illuminate\Database\Seeder;

class Ref_SRS_Kategori_Kes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // check if table is empty
         if(DB::table('ref__srs_kategori_kes')->get()->count() == 0){

            DB::table('ref__srs_kategori_kes')->insert([
                [ 'id' => 1, 'kategori_description' => 'Jenayah Kekerasan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'kategori_description' => 'Jenayah Harta Benda', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'kategori_description' => 'Jenayah Narkotik', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'kategori_description' => 'Gejala Sosial', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

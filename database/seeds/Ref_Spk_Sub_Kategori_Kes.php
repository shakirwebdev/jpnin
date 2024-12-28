<?php

use Illuminate\Database\Seeder;

class Ref_Spk_Sub_Kategori_Kes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table sub kategori is empty
        if(DB::table('ref__spk_sub_kategori_kes')->get()->count() == 0){
            DB::table('ref__spk_sub_kategori_kes')->insert([
                [ 'id' => 1, 'sub_kategori_description' => 'Perhimpunan (≤100)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'sub_kategori_description' => 'Perhimpunan (101-500)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'sub_kategori_description' => 'Perhimpunan Statik (>500)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'sub_kategori_description' => 'Memorandum/ Tandatangan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'sub_kategori_description' => 'Media Sosial', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'sub_kategori_description' => 'Serangan (Asid)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'sub_kategori_description' => 'Serangan (Cat)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'sub_kategori_description' => 'Serangan (Harta Benda)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'sub_kategori_description' => 'Serangan (Molotov)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'sub_kategori_description' => 'Serangan (Senjata)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'sub_kategori_description' => 'Serangan (Tanpa Senjata)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'sub_kategori_description' => 'Lain-Lain', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

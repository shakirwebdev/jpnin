<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Sub_Bidang extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_sub_bidang')->get()->count() == 0){
            DB::table('ref__aktiviti_sub_bidang')->insert([
                [ 'id' => 1, 'bidang_id' => 1, 'sub_bidang_description' => 'Alam Sekitar', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'bidang_id' => 2, 'sub_bidang_description' => 'Kesihatan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'bidang_id' => 3, 'sub_bidang_description' => 'Kesukanan / Rekreasi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'bidang_id' => 3, 'sub_bidang_description' => 'Kemudahan Asas', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'bidang_id' => 3, 'sub_bidang_description' => 'Pemulihan Pelancongan Sosial', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'bidang_id' => 4, 'sub_bidang_description' => 'Islam', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'bidang_id' => 4, 'sub_bidang_description' => 'Kristian', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'bidang_id' => 4, 'sub_bidang_description' => 'Buddha', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'bidang_id' => 4, 'sub_bidang_description' => 'Hindu', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'bidang_id' => 4, 'sub_bidang_description' => 'Sikhism', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'bidang_id' => 4, 'sub_bidang_description' => 'Tao', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'bidang_id' => 4, 'sub_bidang_description' => 'Konfusianisma', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'bidang_id' => 4, 'sub_bidang_description' => 'Bahai', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 14, 'bidang_id' => 4, 'sub_bidang_description' => 'Tiada Agama / Aitismisme', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 15, 'bidang_id' => 5, 'sub_bidang_description' => 'Ekonomi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 16, 'bidang_id' => 6, 'sub_bidang_description' => 'Kebajikan Dan Khidmat Komuniti', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 17, 'bidang_id' => 7, 'sub_bidang_description' => 'Pendidikan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 18, 'bidang_id' => 7, 'sub_bidang_description' => 'Inovasi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 19, 'bidang_id' => 7, 'sub_bidang_description' => 'Tabika / Taska / Krn / Srn', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 20, 'bidang_id' => 7, 'sub_bidang_description' => 'Pembangunan Organisasi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 21, 'bidang_id' => 8, 'sub_bidang_description' => 'Patriotik', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 22, 'bidang_id' => 8, 'sub_bidang_description' => 'Keharmonian', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 23, 'bidang_id' => 8, 'sub_bidang_description' => 'Mediasi Komuniti', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 24, 'bidang_id' => 8, 'sub_bidang_description' => 'Intergrasi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 25, 'bidang_id' => 9, 'sub_bidang_description' => 'Kesenian Dan Budaya', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 26, 'bidang_id' => 10, 'sub_bidang_description' => 'Keselamatan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

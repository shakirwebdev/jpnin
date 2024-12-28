<?php

use Illuminate\Database\Seeder;

class Ref_SRS_Jenis_Kes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__srs_jenis_kes')->get()->count() == 0){
            DB::table('ref__srs_jenis_kes')->insert([
                [ 'id' => 1, 'kategori_id' => 1, 'jenis_description' => 'Pembunuhan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'kategori_id' => 1, 'jenis_description' => 'Rogol', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'kategori_id' => 1, 'jenis_description' => 'Cabul Kehormatan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'kategori_id' => 1, 'jenis_description' => 'Samun', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'kategori_id' => 1, 'jenis_description' => 'Peras Ugut', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'kategori_id' => 1, 'jenis_description' => 'Merusuh', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'kategori_id' => 1, 'jenis_description' => 'Mencedera / Penderaan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'kategori_id' => 2, 'jenis_description' => 'Curi Kenderaan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'kategori_id' => 2, 'jenis_description' => 'Curi Harta Benda', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'kategori_id' => 2, 'jenis_description' => 'Pecah Rumah', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'kategori_id' => 3, 'jenis_description' => 'Pengedaran Dadah', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'kategori_id' => 3, 'jenis_description' => 'Memiliki Dadah', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'kategori_id' => 4, 'jenis_description' => 'Pentengkaran', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 14, 'kategori_id' => 4, 'jenis_description' => 'Lepak', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 15, 'kategori_id' => 4, 'jenis_description' => 'Vandelisme', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 16, 'kategori_id' => 4, 'jenis_description' => 'Khalwat / Maksiat', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 17, 'kategori_id' => 4, 'jenis_description' => 'Pergaduhan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 18, 'kategori_id' => 4, 'jenis_description' => 'Pendatang Tanpa Izin', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 19, 'kategori_id' => 4, 'jenis_description' => 'Lumba Haram', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 20, 'kategori_id' => 4, 'jenis_description' => 'Penagihan Dadah', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 21, 'kategori_id' => 4, 'jenis_description' => 'Masalah Rumah Tangga', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 22, 'kategori_id' => 4, 'jenis_description' => 'Ponteng', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 23, 'kategori_id' => 4, 'jenis_description' => 'Kutu Rayau', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 24, 'kategori_id' => 4, 'jenis_description' => 'Buang Bayi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 25, 'kategori_id' => 4, 'jenis_description' => 'Basikal Lajak', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 26, 'kategori_id' => 4, 'jenis_description' => 'LGBT', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

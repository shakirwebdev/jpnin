<?php

use Illuminate\Database\Seeder;

class RefKemudahanAwam extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__kemudahan_awam')->get()->count() == 0){
            DB::table('ref__kemudahan_awam')->insert([
                [ 'id' => 1, 'kemudahan_awam' => '1', 'kemudahan_awam_description' => 'Balairaya', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'kemudahan_awam' => '2', 'kemudahan_awam_description' => 'Dewan Orang Ramai', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'kemudahan_awam' => '3', 'kemudahan_awam_description' => 'Pusat Komuniti', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'kemudahan_awam' => '4', 'kemudahan_awam_description' => 'Taska', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'kemudahan_awam' => '5', 'kemudahan_awam_description' => 'Tabika', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'kemudahan_awam' => '6', 'kemudahan_awam_description' => 'Tapak Untuk Pembinaan Pusat Komuniti', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'kemudahan_awam' => '7', 'kemudahan_awam_description' => 'Keperluan Asas (air, elektrik,telefon)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'kemudahan_awam' => '8', 'kemudahan_awam_description' => 'Masjid', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'kemudahan_awam' => '9', 'kemudahan_awam_description' => 'Kuil', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'kemudahan_awam' => '10', 'kemudahan_awam_description' => 'Tokong', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'kemudahan_awam' => '11', 'kemudahan_awam_description' => 'Gudwara', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'kemudahan_awam' => '12', 'kemudahan_awam_description' => 'Sekolah Rendah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'kemudahan_awam' => '13', 'kemudahan_awam_description' => 'Sekolah Menengah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 14, 'kemudahan_awam' => '14', 'kemudahan_awam_description' => 'Surau', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 15, 'kemudahan_awam' => '15', 'kemudahan_awam_description' => 'Gereja', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 16, 'kemudahan_awam' => '16', 'kemudahan_awam_description' => 'Chapel', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 17, 'kemudahan_awam' => '17', 'kemudahan_awam_description' => 'Klinik Kesihatan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

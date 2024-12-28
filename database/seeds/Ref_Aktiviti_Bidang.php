<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Bidang extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_bidang')->get()->count() == 0){
            DB::table('ref__aktiviti_bidang')->insert([
                [ 'id' => 1, 'agenda_id' => 1, 'bidang_description' => 'Alam Sekitar', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'agenda_id' => 2, 'bidang_description' => 'Kesihatan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'agenda_id' => 3, 'bidang_description' => 'Rekreasi / Sosial', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'agenda_id' => 3, 'bidang_description' => 'Agama', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'agenda_id' => 3, 'bidang_description' => 'Ekonomi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'agenda_id' => 3, 'bidang_description' => 'Kebajikan Dan Khidmat Komuniti', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'agenda_id' => 3, 'bidang_description' => 'Pendidikan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'agenda_id' => 3, 'bidang_description' => 'Perpaduan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'agenda_id' => 3, 'bidang_description' => 'Kesenian Dan Budaya', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'agenda_id' => 3, 'bidang_description' => 'Keselamatan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

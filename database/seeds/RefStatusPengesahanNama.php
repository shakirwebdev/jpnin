<?php

use Illuminate\Database\Seeder;

class RefStatusPengesahanNama extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_pengesahan_nama')->get()->count() == 0){

            DB::table('ref__status_pengesahan_nama')->insert([
                [ 'id' => 1, 'status' => '1', 'status_description' => 'Belum Disahkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status' => '2', 'status_description' => 'Nama KRT Disahkan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status' => '3', 'status_description' => 'Nama KRT Ditolak', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

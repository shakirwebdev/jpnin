<?php

use Illuminate\Database\Seeder;

class RefStatusBagunan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_bagunan')->get()->count() == 0){

            DB::table('ref__status_bagunan')->insert([
                [ 'id' => 1, 'status_bagunan_description' => 'Binaan Jabatan', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_bagunan_description' => 'Tumpang', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'status_bagunan_description' => 'Sewa', 'status' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

<?php

use Illuminate\Database\Seeder;

class RefJenisKabin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__jenis_kabin')->get()->count() == 0){
            DB::table('ref__jenis_kabin')->insert([
                [ 'id' => 1,  'jenis_kabin_description' => 'NKRA', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2,  'jenis_kabin_description' => 'NBOS (Rapat 1M)', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3,  'jenis_kabin_description' => 'Sumbangan Lain', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

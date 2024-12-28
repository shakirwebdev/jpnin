<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Sumber_Kewangan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_sumber_kewangan')->get()->count() == 0){
            DB::table('ref__aktiviti_sumber_kewangan')->insert([
                [ 'id' => 1, 'kewangan_description' => 'Jabatan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'kewangan_description' => 'Pihak Luar', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

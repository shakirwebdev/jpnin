<?php

use Illuminate\Database\Seeder;

class Ref_SPK_MKP_Peringkat_Kursus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__spk_mkp_peringkat_kursus')->get()->count() == 0){
            DB::table('ref__spk_mkp_peringkat_kursus')->insert([
                [ 'id' => 1, 'peringkat_description' => 'Ibu Pejabat', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'peringkat_description' => 'Negeri', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class Ref_Spk_Peringkat_Kes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__spk_peringkat_kes')->get()->count() == 0){
            DB::table('ref__spk_peringkat_kes')->insert([
                [ 'id' => 1, 'peringkat_description' => 'Nasional', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'peringkat_description' => 'Tempatan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

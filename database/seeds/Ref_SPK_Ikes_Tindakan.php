<?php

use Illuminate\Database\Seeder;

class Ref_SPK_Ikes_Tindakan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__spk_ikes_tindakan')->get()->count() == 0){
            DB::table('ref__spk_ikes_tindakan')->insert([
                [ 'id' => 1, 'tindakan_description' => 'Perjumpaan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'tindakan_description' => 'Mediasi', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'tindakan_description' => 'Kawalan Polis', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'tindakan_description' => 'Tangkapan Polis', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'tindakan_description' => 'Mahkamah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

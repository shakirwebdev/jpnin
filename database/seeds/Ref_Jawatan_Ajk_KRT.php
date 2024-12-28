<?php

use Illuminate\Database\Seeder;

class Ref_Jawatan_Ajk_KRT extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // check if table users is empty
         if(DB::table('ref__jawatan_ajk_krt')->get()->count() == 0){
            DB::table('ref__jawatan_ajk_krt')->insert([
                [ 'id' => 1, 'jawatan_description' => 'Pengerusi', 'jawatan_status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'jawatan_description' => 'Timbalan Pengerusi', 'jawatan_status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'jawatan_description' => 'Setiausaha', 'jawatan_status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'jawatan_description' => 'Bendahari', 'jawatan_status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'jawatan_description' => 'Penolong Setiausaha', 'jawatan_status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'jawatan_description' => 'AJK', 'jawatan_status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

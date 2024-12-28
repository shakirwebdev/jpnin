<?php

use Illuminate\Database\Seeder;

class Ref_KRT_Cawangan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__krt_cawangan')->get()->count() == 0){

            DB::table('ref__krt_cawangan')->insert([
                [ 'id' => 1, 'cawangan_description' => 'Jiran Muda', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'cawangan_description' => 'Tunas Jiran', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'cawangan_description' => 'Jiran Wanita', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'cawangan_description' => 'Jiran Usia Emas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

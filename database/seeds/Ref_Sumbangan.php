<?php

use Illuminate\Database\Seeder;

class Ref_Sumbangan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__sumbangan')->get()->count() == 0){
            DB::table('ref__sumbangan')->insert([
                [ 'id' => 1, 'sumbangan_description' => 'Kewangan (RM)', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'sumbangan_description' => 'Lain - Lain', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

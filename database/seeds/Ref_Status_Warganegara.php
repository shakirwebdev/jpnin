<?php

use Illuminate\Database\Seeder;

class Ref_Status_Warganegara extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__status_warganegara')->get()->count() == 0){
            DB::table('ref__status_warganegara')->insert([
                [ 'id' => 1, 'warganegara_description' => 'Warganegara', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'warganegara_description' => 'Bukan Warganegara', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

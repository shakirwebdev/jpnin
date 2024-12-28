<?php

use Illuminate\Database\Seeder;

class Ref_Status_Status_Etnik extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__status_etnik')->get()->count() == 0){
            DB::table('ref__status_etnik')->insert([
                [ 'id' => 1, 'status_etnik_description' => 'Sesama Etnik', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'status_etnik_description' => 'Berlainan Etnik', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

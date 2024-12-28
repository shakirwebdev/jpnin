<?php

use Illuminate\Database\Seeder;

class Ref_Status_Tbk extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__status_tbk')->get()->count() == 0){

            DB::table('ref__status_tbk')->insert([
                [ 'id' => 1, 'status_description' => 'Lulus', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

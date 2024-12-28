<?php

use Illuminate\Database\Seeder;

class RefJantina extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__jantina')->get()->count() == 0){

            DB::table('ref__jantina')->insert([
                [ 'id' => 1, 'jantina_description' => 'Lelaki', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'jantina_description' => 'Perempuan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
            
        }
    }
}

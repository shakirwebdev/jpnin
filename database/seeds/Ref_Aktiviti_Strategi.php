<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Strategi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_strategi')->get()->count() == 0){
            DB::table('ref__aktiviti_strategi')->insert([
                [ 'id' => 1, 'strategi_description' => 'Strategi 1', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'strategi_description' => 'Strategi 2', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'strategi_description' => 'Strategi 3', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'strategi_description' => 'Strategi 4', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

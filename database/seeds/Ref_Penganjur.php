<?php

use Illuminate\Database\Seeder;

class Ref_Penganjur extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__penganjur')->get()->count() == 0){
            DB::table('ref__penganjur')->insert([
                [ 'id' => 1, 'penganjur_description' => 'Ibu Pejabat', 'penganjur_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'penganjur_description' => 'Negeri', 'penganjur_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'penganjur_description' => 'Daerah', 'penganjur_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'penganjur_description' => 'Rukun Tetangga', 'penganjur_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

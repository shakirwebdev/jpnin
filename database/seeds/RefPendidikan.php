<?php

use Illuminate\Database\Seeder;

class RefPendidikan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__pendidikan')->get()->count() == 0){
            DB::table('ref__pendidikan')->insert([
                [ 'id' => 1, 'pendidikan_description' => 'Doctor Falsafah (PHD)', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'pendidikan_description' => 'Sarjana', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'pendidikan_description' => 'Sarjana Muda', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'pendidikan_description' => 'Diploma', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'pendidikan_description' => 'STPM dan Setaraf', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'pendidikan_description' => 'SPM / SPVM & Setaraf', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'pendidikan_description' => 'PMR / SRP & Setaraf', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'pendidikan_description' => 'Sekolah Rendah', 'pendidikan_status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);
        }
    }
}

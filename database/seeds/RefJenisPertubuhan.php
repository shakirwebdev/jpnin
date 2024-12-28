<?php

use Illuminate\Database\Seeder;

class RefJenisPertubuhan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__jenis_pertubuhan')->get()->count() == 0){
            DB::table('ref__jenis_pertubuhan')->insert([
                [ 'id' => 1, 'jenis_pertubuhan' => '1', 'jenis_pertubuhan_description' => 'MPP', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'jenis_pertubuhan' => '2', 'jenis_pertubuhan_description' => 'MPKK', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'jenis_pertubuhan' => '3', 'jenis_pertubuhan_description' => 'Persatuan Penduduk', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'jenis_pertubuhan' => '4', 'jenis_pertubuhan_description' => 'Joint Management Body (JMB)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'jenis_pertubuhan' => '5', 'jenis_pertubuhan_description' => 'Lain-lain : (Contoh :Rela, Persatuan Belia, Community Policing dan sebagainya)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

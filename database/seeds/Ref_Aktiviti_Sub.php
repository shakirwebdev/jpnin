<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Sub extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_sub')->get()->count() == 0){
            DB::table('ref__aktiviti_sub')->insert([
                [ 'id' => 1, 'aktiviti_id' => '10', 'sub_aktiviti_description' => 'Covid-19', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'aktiviti_id' => '10', 'sub_aktiviti_description' => 'Hebahan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'aktiviti_id' => '10', 'sub_aktiviti_description' => 'Jahitan Alat Perlindungan Diri', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'aktiviti_id' => '10', 'sub_aktiviti_description' => 'Penyediaan kotak makanan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'aktiviti_id' => '10', 'sub_aktiviti_description' => 'Sumbangan / bantuan kebajikan mangsa terkesan', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'aktiviti_id' => '10', 'sub_aktiviti_description' => 'Membantu pendaftaran vaksin', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Kospen', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Combi', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Jom Sihat', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Jaga diri leklok', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Kepimpinan sihat dan sejahtera', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Program Minda Sjahtera', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'aktiviti_id' => '11', 'sub_aktiviti_description' => 'Duta Jom Sihat', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

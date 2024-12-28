<?php

use Illuminate\Database\Seeder;

class RefProfession extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__profession')->get()->count() == 0){
            DB::table('ref__profession')->insert([
                [ 'id' => 1, 'profession' => '1', 'profession_description' => 'Kakitangan Kerajaan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'profession' => '2', 'profession_description' => 'Kumpulan Pengurusan & Profesional', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'profession' => '3', 'profession_description' => 'Kumpulan Sokongan I', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'profession' => '4', 'profession_description' => 'Kumpulan Sokongan II', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'profession' => '5', 'profession_description' => 'Bekerja Dengan Sektor Swasta', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'profession' => '6', 'profession_description' => 'Eksekutif', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'profession' => '7', 'profession_description' => 'Bukan Eksekutif', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'profession' => '8', 'profession_description' => 'Berniaga', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'profession' => '9', 'profession_description' => 'Pemilik syarikat', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'profession' => '10', 'profession_description' => 'Pengusaha IKS', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'profession' => '11', 'profession_description' => 'Peruncit / Pemborong', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'profession' => '12', 'profession_description' => 'Peniaga Gerai (gerai makanan/pasar malam/pasar basah dan sbgnya)', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'profession' => '13', 'profession_description' => 'Pesara Kerajaan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 14, 'profession' => '14', 'profession_description' => 'Kerajaan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 15, 'profession' => '15', 'profession_description' => 'Swasta', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

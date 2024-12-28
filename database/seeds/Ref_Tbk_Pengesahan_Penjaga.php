<?php

use Illuminate\Database\Seeder;

class Ref_Tbk_Pengesahan_Penjaga extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__tbk_pengesahan_penjaga')->get()->count() == 0){
            DB::table('ref__tbk_pengesahan_penjaga')->insert([
                [ 'id' => 1, 'pengesahan_description' => 'Saya Mengesahkan Segala Maklumat Yang Dinyatakan Adalah Benar', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'pengesahan_description' => 'Saya Akan Patuh Kepada Semua Peraturan Yang Ditetapkan Oleh Jabatan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'pengesahan_description' => 'Saya Bersedia Menjadi Ahli Jawatankuasa Penyelaras Tabika Perpaduan, memberi kerjasama dan sokongan sepenuhnya dalam setiap aktiviti yang dilaksanakan di peringkat kelas dan Jabatan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

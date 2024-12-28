<?php

use Illuminate\Database\Seeder;

class RefJenisKewangan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__jenis_kewangan')->get()->count() == 0){

            DB::table('ref__jenis_kewangan')->insert([
                [ 'id' => 1, 'jenis_kewangan_description' => 'Penerimaan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'jenis_kewangan_description' => 'Pembayaran', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

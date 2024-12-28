<?php

use Illuminate\Database\Seeder;

class RefPertanian extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__pertanian')->get()->count() == 0){
            DB::table('ref__pertanian')->insert([
                [ 'id' => 1, 'pertanian' => '1', 'pertanian_description' => 'Kelapa sawit', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'pertanian' => '2', 'pertanian_description' => 'Kelapa', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'pertanian' => '3', 'pertanian_description' => 'Sawah padi', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'pertanian' => '4', 'pertanian_description' => 'Kebun pisang', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'pertanian' => '5', 'pertanian_description' => 'Ladang tebu', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'pertanian' => '6', 'pertanian_description' => 'Getah', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'pertanian' => '7', 'pertanian_description' => 'Kebun sayur', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'pertanian' => '8', 'pertanian_description' => 'Ladang buah-buahan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'pertanian' => '9', 'pertanian_description' => 'Kolam ikan', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'pertanian' => '10', 'pertanian_description' => 'Kandang kambing', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'pertanian' => '11', 'pertanian_description' => 'Kandang lembu', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'pertanian' => '12', 'pertanian_description' => 'Reban ayam besar-besaran', 'status'=>1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

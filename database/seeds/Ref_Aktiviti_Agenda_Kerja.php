<?php

use Illuminate\Database\Seeder;

class Ref_Aktiviti_Agenda_Kerja extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('ref__aktiviti_agenda_kerja')->get()->count() == 0){
            DB::table('ref__aktiviti_agenda_kerja')->insert([
                [ 'id' => 1, 'agenda_description' => 'Gerak Kerja KRT Bersih Dan Indah', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'agenda_description' => 'Gerak Kerja KRT Sihat', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'agenda_description' => 'Gerak Kerja KRT Sejahtera', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'agenda_description' => 'Gerak Kerja KRT Selamat', 'status'=> 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);
        }
    }
}

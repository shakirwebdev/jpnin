<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefRolesMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__roles_menus')->get()->count() == 0){

            DB::table('ref__roles_menus')->insert([
                [
                    'id' => 1,
                    'url' => 'dashboard/index',
                    'nama' => 'Dashboard',
                    'ikon' => 'icon-screen-desktop',
                    'tabs' => false,
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'url' => 'rt/sm1/permohonan-penubuhan-krt',
                    'nama' => 'Permohonan Penubuhan KRT',
                    'ikon' => 'icon-note',
                    'tabs' => false,
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]);            
        }
    }
}

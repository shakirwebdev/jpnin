<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefRolesUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__roles_users')->get()->count() == 0){

            DB::table('ref__roles_users')->insert([
                [
                    'id' => 1,
                    'short_description' => 'Developer',
                    'long_description' => 'Developer',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'short_description' => 'Orang Awam',
                    'long_description' => 'Orang Awam',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'short_description' => 'PPD',
                    'long_description' => 'Pegawai Perpaduan Daerah',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 4,
                    'short_description' => 'PPN',
                    'long_description' => 'Pengarah Perpaduan Negeri',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 5,
                    'short_description' => 'HQ (RT)',
                    'long_description' => 'Ibu Pejabat (Rukun Tetangga)',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 6,
                    'short_description' => 'HQ (UKK)',
                    'long_description' => 'Ibu Pejabat (Unit Keselamatan Komuniti',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 7,
                    'short_description' => 'HQ (UPK)',
                    'long_description' => 'Ibu Pejabat (Unit Pengurusan Konflik)',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 8,
                    'short_description' => 'HQ (SRS)',
                    'long_description' => 'Ibu Pejabat (Skim Rondaan Sukarela)',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 9,
                    'short_description' => 'Ketua Pengarah RT',
                    'long_description' => 'Ketua Pengarah RT',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 10,
                    'short_description' => 'Pengerusi',
                    'long_description' => 'Pengerusi',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 11,
                    'short_description' => 'Setiausaha',
                    'long_description' => 'Setiausaha',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 12,
                    'short_description' => 'Bendahari',
                    'long_description' => 'Bendahari',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 13,
                    'short_description' => 'Ketua Peronda',
                    'long_description' => 'Ketua Peronda',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 14,
                    'short_description' => 'Pentadbir Sistem',
                    'long_description' => 'Pentadbir Sistem',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 15,
                    'short_description' => 'MKP',
                    'long_description' => 'Mediator Komuniti',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 16,
                    'short_description' => 'PPD',
                    'long_description' => 'Pegawai Perpaduan Daerah e-Sepakat',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 17,
                    'short_description' => 'PPMK',
                    'long_description' => 'Pegawai Penyelaras Mediator Komuniti',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 18,
                    'short_description' => 'PPN',
                    'long_description' => 'Pengarah Perpaduan Negeri e-Sepakat',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 19,
                    'short_description' => 'BPP (UPK)',
                    'long_description' => 'Bahagian Pengurusan Perpaduan',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 20,
                    'short_description' => 'P (PP)',
                    'long_description' => 'Pengarah (Pengurusan Perpaduan)',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 21,
                    'short_description' => 'HQ (UPMK)',
                    'long_description' => 'Unit Perkhidmatan Mediasi Komuniti',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 22,
                    'short_description' => 'TKP (P)',
                    'long_description' => 'Timbalan Ketua Pengarah (Perancangan)',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 23,
                    'short_description' => 'KP',
                    'long_description' => 'Ketua Pengarah',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 24,
                    'short_description' => 'KPN',
                    'long_description' => 'Kementerian Perpaduan Negara',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 25,
                    'short_description' => 'Pentadbir Sistem',
                    'long_description' => 'Pentadbir Sistem e-Sepakat',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]);

        }
    }
}

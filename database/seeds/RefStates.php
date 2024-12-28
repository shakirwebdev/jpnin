<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefStates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('ref__states')->get()->count() == 0){

            DB::table('ref__states')->insert([
                [
                    'id' => 1,
                    'state_id' => '01',
                    'state_abbr' => 'jhr',
                    'state_description' => 'JOHOR',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'state_id' => '02',
                    'state_abbr' => 'kdh',
                    'state_description' => 'KEDAH',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'state_id' => '03',
                    'state_abbr' => 'ktn',
                    'state_description' => 'KELANTAN',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'state_id' => '04',
                    'state_abbr' => 'mlk',
                    'state_description' => 'MELAKA',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'state_id' => '05',
                    'state_abbr' => 'nsn',
                    'state_description' => 'NEGERI SEMBILAN',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'state_id' => '06',
                    'state_abbr' => 'phg',
                    'state_description' => 'PAHANG',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 7,
                    'state_id' => '07',
                    'state_abbr' => 'png',
                    'state_description' => 'PULAU PINANG',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 8,
                    'state_id' => '08',
                    'state_abbr' => 'prk',
                    'state_description' => 'PERAK',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 9,
                    'state_id' => '09',
                    'state_abbr' => 'pls',
                    'state_description' => 'PERLIS',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 10,
                    'state_id' => '10',
                    'state_abbr' => 'sgr',
                    'state_description' => 'SELANGOR',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 11,
                    'state_id' => '11',
                    'state_abbr' => 'trg',
                    'state_description' => 'TERENGGANU',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 12,
                    'state_id' => '12',
                    'state_abbr' => 'sbh',
                    'state_description' => 'SABAH',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 13,
                    'state_id' => '13',
                    'state_abbr' => 'swk',
                    'state_description' => 'SARAWAK',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 14,
                    'state_id' => '14',
                    'state_abbr' => 'kul',
                    'state_description' => 'W.P KUALA LUMPUR',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 15,
                    'state_id' => '15',
                    'state_abbr' => 'lbn',
                    'state_description' => 'W.P LABUAN',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 16,
                    'state_id' => '16',
                    'state_abbr' => 'pjy',
                    'state_description' => 'W.P PUTRAJAYA',
                    'status' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);

        }
    }
}

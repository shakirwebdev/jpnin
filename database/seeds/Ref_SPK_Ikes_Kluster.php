<?php

use Illuminate\Database\Seeder;

class Ref_SPK_Ikes_Kluster extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table is empty
        if(DB::table('ref__spk_ikes_kluster')->get()->count() == 0){

            DB::table('ref__spk_ikes_kluster')->insert([
                [ 'id' => 1, 'kluster_description' => 'POLITIK', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'kluster_description' => 'EKONOMI', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'kluster_description' => 'KESELAMATAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'kluster_description' => 'SOSIAL DAN KOMUNIKASI', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'kluster_description' => 'PERSEKITARAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'kluster_description' => 'KERAJAAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'kluster_description' => 'PENDIDIKAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'kluster_description' => 'PERKAUMAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'kluster_description' => 'AGAMA', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'kluster_description' => 'KENYATAAN BERBAUR KEBENCIAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ]);

        }
    }
}

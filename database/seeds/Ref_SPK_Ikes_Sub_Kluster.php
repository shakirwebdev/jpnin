<?php

use Illuminate\Database\Seeder;

class Ref_SPK_Ikes_Sub_Kluster extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // check if table is empty
         if(DB::table('ref__spk_ikes_sub_kluster')->get()->count() == 0){

            DB::table('ref__spk_ikes_sub_kluster')->insert([
                [ 'id' => 1, 'kluster_id' => '1', 'subkluster_description' => 'PELBAGAI POLITIK', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 2, 'kluster_id' => '2', 'subkluster_description' => 'PERNIAGAAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 3, 'kluster_id' => '2', 'subkluster_description' => 'PEKERJA', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 4, 'kluster_id' => '2', 'subkluster_description' => 'KEPENGGUNAAN & KOS SARA HIDUP', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 5, 'kluster_id' => '3', 'subkluster_description' => 'SERANGAN JENAYAH FIZIKAL', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 6, 'kluster_id' => '3', 'subkluster_description' => 'KESELAMATAN AWAM', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 7, 'kluster_id' => '3', 'subkluster_description' => 'WARGA ASING', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 8, 'kluster_id' => '4', 'subkluster_description' => 'AGAMA', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 9, 'kluster_id' => '4', 'subkluster_description' => 'PERKAUMAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 10, 'kluster_id' => '4', 'subkluster_description' => 'KENYATAAN BERBAUR KEBENCIAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 11, 'kluster_id' => '4', 'subkluster_description' => 'KOMUNITI', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 12, 'kluster_id' => '5', 'subkluster_description' => 'TANAH', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 13, 'kluster_id' => '5', 'subkluster_description' => 'PROJEK PEMBANGUNAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 14, 'kluster_id' => '5', 'subkluster_description' => 'PENYAMPAIAN PERKHIDMATAN (KERJAAN)', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 15, 'kluster_id' => '5', 'subkluster_description' => 'ALAM SEKITAR', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 16, 'kluster_id' => '6', 'subkluster_description' => 'PENGERUSAN & PENTADBIRAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 17, 'kluster_id' => '7', 'subkluster_description' => 'PENDIDIKAN', 'status' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 18, 'kluster_id' => '8', 'subkluster_description' => 'PERKAUMAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 19, 'kluster_id' => '8', 'subkluster_description' => 'DISKRIMINASI KAUM', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 20, 'kluster_id' => '8', 'subkluster_description' => 'ISU PENDIDIKAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 21, 'kluster_id' => '8', 'subkluster_description' => 'PERGADUHAN ANTARA KAUM', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 22, 'kluster_id' => '8', 'subkluster_description' => 'PELBAGAI ISU PERKAUMAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 23, 'kluster_id' => '9', 'subkluster_description' => 'PENGURUSAN RUMAH IBADAT SELAIN ISLAM', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 24, 'kluster_id' => '9', 'subkluster_description' => 'MURTAD / PERTUKARAN AGAMA / AJARAN SESAT', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 25, 'kluster_id' => '9', 'subkluster_description' => 'ISLAM', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 26, 'kluster_id' => '9', 'subkluster_description' => 'DISKRIMINASI AGAMA', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 27, 'kluster_id' => '9', 'subkluster_description' => 'PELBAGAI ISU AGAMA', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 28, 'kluster_id' => '10', 'subkluster_description' => 'PENGHINAAN KEPADA INSTITUSI DIRAJA', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 29, 'kluster_id' => '10', 'subkluster_description' => 'PENGHINAAN KEPADA PEMIMPIN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 30, 'kluster_id' => '10', 'subkluster_description' => 'PENGHINAAN KEPADA AGAMA', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 31, 'kluster_id' => '10', 'subkluster_description' => 'PELBAGAI KENYATAAN BERBAUR KEBENCIAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 32, 'kluster_id' => '6', 'subkluster_description' => 'PENYAMPAIAN PERKHIDMATAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 33, 'kluster_id' => '6', 'subkluster_description' => 'ISU POLITIK', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 34, 'kluster_id' => '6', 'subkluster_description' => 'ISU WARGA ASING', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 35, 'kluster_id' => '6', 'subkluster_description' => 'PIHAK BERKUASA TEMPATAN (PBT)', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 36, 'kluster_id' => '6', 'subkluster_description' => 'KEPENGGUNAAN DAN KOS SARA HIDUP', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 37, 'kluster_id' => '6', 'subkluster_description' => 'PELBAGAI ISU KERAJAAN', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 38, 'kluster_id' => '3', 'subkluster_description' => 'KENTENTERAMAN AWAM', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 39, 'kluster_id' => '3', 'subkluster_description' => 'PENINGKATAN KADAR JENAYAH', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                [ 'id' => 40, 'kluster_id' => '3', 'subkluster_description' => 'PELBAGAI ISU KESELAMATAN DAN JENAYAH', 'status' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ]);

        }
    }
}

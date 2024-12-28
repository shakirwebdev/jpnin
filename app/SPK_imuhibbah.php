<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imuhibbah extends Model
{
    protected $table = "spk__imuhibbah";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'hasRT', 
                            'krt_profile_id', 
                            'imuhibbah_tajuk',
                            'state_id',
                            'daerah_id',
                            'bandar_id',
                            'imuhibbah_kawasan',
                            'imuhibbah_lokasi',
                            'imuhibbah_poskod',
                            'parlimen_id',
                            'dun_id',
                            'pbt_id',
                            'imuhibbah_tarikh_laporan',
                            'imuhibbah_tarikh_j_berlaku',
                            'imuhibbah_laporan',
                            'imuhibbah_sumber_maklumat',
                            'imuhibbah_pelapor_nama',
                            'imuhibbah_pelapor_no',
                            'imuhibbah_pelapor_jawatan',
                            'imuhibbah_pelapor_alamat',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'diakui_by',
                            'diakui_note',
                            'diakui_date',
                            'disemak_by',
                            'disemak_note',
                            'disemak_date',
                            'disahkan_by',
                            'disahkan_note',
                            'disahkan_date',
                        ];
}

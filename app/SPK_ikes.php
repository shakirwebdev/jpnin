<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_ikes extends Model
{
    protected $table = "spk__ikes";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'hasRT', 
                            'krt_profile_id', 
                            'state_id',
                            'daerah_id',
                            'bandar_id',
                            'ikes_kawasan',
                            'ikes_lokasi',
                            'ikes_poskod',
                            'parlimen_id',
                            'dun_id',
                            'pbt_id',
                            'ikes_bpolis',
                            'ikes_tarikh_berlaku',
                            'peringkat_id',
                            'kategori_id',
                            'ikes_keterangan_kes',
                            'ikes_tindakan_awal',
                            'ikes_sumber',
                            'ikes_bil_terlibat',
                            'status_warganegara_id',
                            'status_etnik_id',
                            'ikes_bil_tangkapan',
                            'hasTindakan',
                            'ikes_keterangan_tindakan',
                            'ikes_keadaan_semasa',
                            'ikes_jangkaan_keadaan',
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

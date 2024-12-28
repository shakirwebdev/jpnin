<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Sejiwa extends Model
{
    protected $table = "krt__profile_sejiwa";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'sejiwa_nama', 
                            'sejiwa_tarikh_ditubuhkan', 
                            'sejiwa_pusat_operasi',
                            'sejiwa_nama_pengerusi',
                            'sejiwa_ic_pengerusi',
                            'sejiwa_phone_pengerusi',
                            'sejiwa_email_pengerusi',
                            'sejiwa_alamat_pengerusi',
                            'sejiwa_pekerjaan_pengerusi',
                            'sejiwa_nama_timbalan',
                            'sejiwa_ic_timbalan',
                            'sejiwa_phone_timbalan',
                            'sejiwa_email_timbalan',
                            'sejiwa_alamat_timbalan',
                            'sejiwa_pekerjaan_timbalan',
                            'sejiwa_nama_su',
                            'sejiwa_ic_su',
                            'sejiwa_phone_su',
                            'sejiwa_email_su',
                            'sejiwa_alamat_su',
                            'sejiwa_pekerjaan_su',
                            'sejiwa_pegawai_nama',
                            'sejiwa_pegawai_jawatan',
                            'sejiwa_pegawai_phone',
                            'sejiwa_pegawai_emel',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note'
                        ];
}

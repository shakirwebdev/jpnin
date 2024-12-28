<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Koperasi extends Model
{
    protected $table = "krt__koperasi";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'koperasi_nama', 
                            'koperasi_tarikh_daftar',
                            'koperasi_bilangan_ahli_lembaga',
                            'koperasi_jumlah_anggota',
                            'status_koperasi_id',
                            'koperasi_pendapatan_semasa',
                            'koperasi_pendapatan_sebelum',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                        ];
}

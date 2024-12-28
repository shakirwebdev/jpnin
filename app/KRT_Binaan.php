<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Binaan extends Model
{
    protected $table = "krt__binaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'binaan_jenis_premis_id', 
                            'binaan_alamat',
                            'binaan_tanah_ptp',
                            'binaan_tanah_negeri',
                            'binaan_kos',
                            'binaan_keluasan_tanah',
                            'binaan_keluasan_bagunan',
                            'binaan_tarikh_mula_bina',
                            'binaan_pengguna_rt',
                            'binaan_pengguna_srs',
                            'binaan_pengguna_tabika',
                            'binaan_pengguna_taska',
                            'binaan_isu',
                        ];
}

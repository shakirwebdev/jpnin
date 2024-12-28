<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_CadanganPembinaanPRT extends Model
{
    protected $table = "krt__pembinaan_prt1";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'prt_jenis_premis', 
                            'prt_status_tanah_terkini',
                            'prt_keluasan',
                            'prt_status_kelulusan_tanah_kabin',
                            'prt_cadangan_tahun',
                        ];
}

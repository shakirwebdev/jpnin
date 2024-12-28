<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Pelaksanaan_Rondaan extends Model
{
    protected $table = "srs__pelaksanaan_rondaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'srs_profile_id', 
                            'pelaksanaan_rondaan_tarikh',
                            'pelaksanaan_rondaan_kes',
                            'kategori_kes_id',
                            'kes_keterangan',
                            'jenis_kes_id',
                            'kes_jumlah_org_terlibat',
                            'kes_dirujuk_id',
                            'pelaksanaan_rondaan_status',
                            'direkod_by',
                            'direkod_date',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note'
                        ];
}

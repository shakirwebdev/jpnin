<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Isu_masalah_lokasi_kanta_komuniti extends Model
{
    protected $table = "krt__isu_masalah_lokasi_kanta_komuniti";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'isu_lokasi_kanta_komuniti',
                            'isu_kluster',
                            'isu_bil_terlibat',
                            'isu_pelaksanan_daerah',
                            'isu_pelaksanan_negeri',
                            'isu_agensi_terlibat',
                            'isu_status',
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

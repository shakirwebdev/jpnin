<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Projek_Ekonomi extends Model
{
    protected $table = "krt__projek_ekonomi";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'projek_nama', 
                            'projek_penerangan',
                            'status_pelaksanaan_projek_id',
                            'sekala_project_semasa_id',
                            'sekala_project_hadapan_id',
                            'projek_jaringan',
                            'projek_tahun',
                            'projek_impak',
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

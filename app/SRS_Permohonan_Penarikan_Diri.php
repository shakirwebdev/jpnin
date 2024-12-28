<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Permohonan_Penarikan_Diri extends Model
{
    protected $table = "srs__permohonan_penarikan_diri";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'srs_profile_id',
                            'ahli_peronda_id', 
                            'alasan_id', 
                            'penarikan_diri_nyatakan',
                            'penarikan_diri_status',
                            'direkod_by',
                            'direkod_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                        ];
}

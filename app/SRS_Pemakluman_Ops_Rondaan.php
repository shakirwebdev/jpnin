<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Pemakluman_Ops_Rondaan extends Model
{
    protected $table = "srs__pemakluman_ops_rondaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'srs_profile_id', 
                            'ops_tarikh_mula_ronda',
                            'ops_tarikh_surat',
                            'direkod_by',
                            'direkod_date'
                        ];
}

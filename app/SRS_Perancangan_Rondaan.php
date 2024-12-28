<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Perancangan_Rondaan extends Model
{
    protected $table = "srs__perancangan_rondaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'srs_profile_id', 
                            'perancangan_rondaan_tarikh',
                            'perancangan_rondaan_status',
                            'direkod_by',
                            'direkod_date'
                        ];
}

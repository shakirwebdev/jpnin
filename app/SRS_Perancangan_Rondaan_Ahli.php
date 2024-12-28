<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Perancangan_Rondaan_Ahli extends Model
{
    protected $table = "srs__perancangan_rondaan_ahli";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_perancangan_rondaan_id', 
                            'srs_ahli_peronda', 
                        ];
}

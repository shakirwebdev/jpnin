<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Pelaksanaan_Rondaan_Ahli extends Model
{
    protected $table = "srs__pelaksanaan_rondaan_ahli";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_pelaksanaan_rondaan_id', 
                            'srs_ahli_peronda', 
                        ];
}

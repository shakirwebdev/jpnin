<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Pelaksanaan_Rondaan_Kes_Terlibat extends Model
{
    protected $table = "srs__pelaksanaan_rondaan_kes_terlibat";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_pelaksanaan_rondaan_id', 
                            'kaum_id', 
                            'jantina_id',
                            'terlibat_bilangan',
                            'terlibat_umur'
                        ];
}

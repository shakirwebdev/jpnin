<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Isu_masalah_lokasi_kanta_komuniti_terlibat extends Model
{
    protected $table = "krt__isu_masalah_lokasi_kanta_komuniti_terlibat";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'isu_lokasi_kk_id',
                            'bilangan',
                            'kaum_id',
                            'jantina_id',
                            'umur'
                        ];
}

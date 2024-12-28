<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa_Cawangan_Akademik extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa_cawangan_akademik";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_ajk_cawangan_id', 
                            'pendidikan_id', 
                            'akademik_tahun',
                            'akademik_pencapaian',
                        ];
}

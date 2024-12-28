<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa_Cawangan_Pengalaman extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa_cawangan_pengalaman";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_ajk_cawangan_id', 
                            'pengalaman_tahun',
                            'pengalaman_program'
                        ];
}

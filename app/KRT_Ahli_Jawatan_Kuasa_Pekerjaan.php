<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa_Pekerjaan extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa_pekerjaaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_ajkID', 
                            'ref_profession_id', 
                        ];
}

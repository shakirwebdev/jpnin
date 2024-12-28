<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa_Pendidikan extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa_pendidikan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_ajkID', 
                            'ref_pendidikanID', 
                        ];
}

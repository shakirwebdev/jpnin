<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Minit_Mesyuarat_Kertas_Kerja extends Model
{
    protected $table = "krt__minit_mesyuarat_kertas_kerja";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_minit_mesyuarat_id', 
                            'kertas_kerja_perkara', 
                            'kertas_kerja_tindakan'
                        ];
}

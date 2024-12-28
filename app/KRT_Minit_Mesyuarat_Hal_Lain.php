<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Minit_Mesyuarat_Hal_Lain extends Model
{
    protected $table = "krt__minit_mesyuarat_hal_lain";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_minit_mesyuarat_id', 
                            'hal_lain_perkara', 
                            'hal_lain_tindakan'
                        ];
}

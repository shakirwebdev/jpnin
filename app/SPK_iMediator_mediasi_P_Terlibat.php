<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_iMediator_mediasi_P_Terlibat extends Model
{
    protected $table = "spk__imediator_mediasi_p_terlibat";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imediator_mediasi_id', 
                            'pihak_pertama', 
                            'pihak_kedua'
                        ];
}

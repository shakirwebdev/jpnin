<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imediator_Keaktifan_Sumbangan extends Model
{
    protected $table = "spk__imediator_keaktifan_sumbangan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imediator_id', 
                            'sumbangan_nama', 
                            'ref_peringkat_id', 
                        ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_ikes_terlibat extends Model
{
    protected $table = "spk__ikes_terlibat";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_ikes_id', 
                            'ref_spk_terlibat_id', 
                        ];
}

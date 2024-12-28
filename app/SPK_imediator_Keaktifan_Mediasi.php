<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imediator_Keaktifan_Mediasi extends Model
{
    protected $table = "spk__imediator_keaktifan_mediasi";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_mkp_keaktifan_id', 
                            'ref_spk_mkp_mediasi_id', 
                            'ref_spk_mkp_mediasi_status_id',
                            'ref_spk_mkp_peringkat_id',
                        ];
}

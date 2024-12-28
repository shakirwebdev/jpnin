<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imediator_Keaktifan_Aktiviti extends Model
{
    protected $table = "spk__imediator_keaktifan_aktiviti";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imediator_id', 
                            'aktiviti_nama', 
                            'aktiviti_tarikh', 
                            'aktiviti_tempat',
                            'aktiviti_jawatan',
                            'ref_peringkat_id',
                        ];
}

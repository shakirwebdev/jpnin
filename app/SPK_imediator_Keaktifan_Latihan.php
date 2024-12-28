<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imediator_Keaktifan_Latihan extends Model
{
    protected $table = "spk__imediator_keaktifan_latihan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imediator_id', 
                            'latihan_nama', 
                            'latihan_tarikh', 
                            'latihan_tempat',
                            'latihan_penganjur',
                            'ref_peringkat_id',
                        ];
}

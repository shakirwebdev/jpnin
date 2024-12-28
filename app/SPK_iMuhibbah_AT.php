<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_iMuhibbah_AT extends Model
{
    protected $table = "spk__imuhibbah_at";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imuhibbah_id', 
                            'tempoh_tindakan', 
                            'tarikh_arahan',
                            'jenis_arahan_id',
                            'tindakan_kepada_ppn',
                            'tindakan_kepada_ppd',
                            'arahan_by',
                        ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_iMuhibbah_TS extends Model
{
    protected $table = "spk__imuhibbah_ts";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imuhibbah_at_id', 
                            'tarikh_tindakan', 
                            'keterangan_tindakan',
                            'tindakan_susulan_by',
                        ];
}

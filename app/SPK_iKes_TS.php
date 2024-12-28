<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_iKes_TS extends Model
{
    protected $table = "spk__ikes_ts";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_ikes_at_id', 
                            'tarikh_tindakan', 
                            'keterangan_tindakan',
                            'tindakan_susulan_by',
                        ];
}

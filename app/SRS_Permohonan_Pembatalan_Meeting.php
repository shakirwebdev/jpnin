<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Permohonan_Pembatalan_Meeting extends Model
{
    protected $table = "srs__permohonan_pembatalan_meeting";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'pembatalan_srs_id', 
                            'minit_mesyuarat_id', 
                            'keterangan',
                        ];
}

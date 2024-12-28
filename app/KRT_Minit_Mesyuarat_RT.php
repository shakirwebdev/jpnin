<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Minit_Mesyuarat_RT extends Model
{
    protected $table = "krt__minit_mesyuarat";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'mesyuarat_title', 
                            'mesyuarat_bil',
                            'mesyuarat_tarikh',
                            'mesyuarat_time',
                            'mesyuarat_tempat',
                            'mesyuarat_perutusan_pengerusi',
                            'mesyuarat_yang_lalu',
                            'mesyuarat_penyata_kewangan',
                            'mesyuarat_penutup',
                            'mesyuarat_disedia',
                            'mesyuarat_disemak',
                            'mesyuarat_status',
                            'direkodby_oleh',
                            'direkod_date',
                            'disemakby_oleh',
                            'disemak_date',
                            'disemak_note',
                        ];
}

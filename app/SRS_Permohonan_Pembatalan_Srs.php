<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Permohonan_Pembatalan_Srs extends Model
{
    protected $table = "srs__permohonan_pembatalan_srs";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'srs_profile_id',
                            'pembatalan_status', 
                            'direkod_by', 
                            'direkod_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                            'diluluskan_by',
                            'diluluskan_date',
                            'diluluskan_note',
                        ];
}

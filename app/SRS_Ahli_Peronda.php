<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Ahli_Peronda extends Model
{
    protected $table = "srs__ahli_peronda";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profile_id', 
                            'file_gambar_profile', 
                            'peronda_nama', 
                            'peronda_ic',
                            'peronda_tarikh_lahir',
                            'peronda_kaum',
                            'peronda_jantina',
                            'peronda_warganegara',
                            'peronda_phone',
                            'peronda_alamat',
                            'peronda_poskod',
                            'peronda_tarikh_lantikan',
                            'peronda_status',
                            'direkod_by',
                            'direkod_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                        ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile extends Model
{
    protected $table = "krt__profile";
    protected $primaryKey = 'id';
    protected $fillable = [
        'rt_applicationID',
        'krt_nama',
        'krt_alamat',
        'state_id',
        'daerah_id',
        'parlimen_id',
        'dun_id',
        'krt_pbt',
        'krt_kawasan',
        'krt_keluasan',
        'krt_ipd',
        'krt_balai',
        'srs_nama',
        'krt_tabika',
        'krt_taska',
        'krt_status_bagunan_id',
        'krt_status',
        'submitby_user_id',
        'submited_date',
        'disemakby_user_id',
        'disemak_note',
        'disemak_date',
        'disahkanby_user_id',
        'disahkan_note',
        'disahkan_date',
        'diluluskanby_user_id',
        'diluluskan_note',
        'diluluskan_date'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Pembatalan extends Model
{
    protected $table = "krt__pembatalan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'tujuan_pembatalan_id', 
                            'nyatakan_tujuan',
                            'status',
                            'direkod_by',
                            'direkod_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disokong_by',
                            'disokong_date',
                            'disokong_note',
                            'diluluskan_by',
                            'diluluskan_date',
                            'diluluskan_note',
                        ];
}
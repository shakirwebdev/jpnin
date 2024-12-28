<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Profile extends Model
{
    protected $table = "srs__profile";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_id', 
                            'srs_name', 
                            'srs_peronda_total',
                            'srs_kawalan',
                            'srs_status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                            'diakui_by',
                            'diakui_date',
                            'diakui_note',
                            'diluluskan_by',
                            'diluluskan_date',
                            'diluluskan_note',
                        ];
}

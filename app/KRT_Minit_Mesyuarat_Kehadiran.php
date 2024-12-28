<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Minit_Mesyuarat_Kehadiran extends Model
{
    protected $table = "krt__minit_mesyuarat_kehadiran";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_minit_mesyuarat_id', 
                            'kehadiran_nama', 
                            'kehadiran_ic'
                        ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Pembatalan_Meeting extends Model
{
    protected $table = "krt__pembatalan_meeting";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_pembatalan_id', 
                            'minit_mesyuarat_id', 
                            'keterangan',
                        ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Langkah_Masalah extends Model
{
    protected $table = "krt__kanta_komuniti_langkah_masalah";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'masalah_id',
                            'langkah_diambil',
                            'langkah_pelaksanaan',
                            'langkah_status'
                        ];
}

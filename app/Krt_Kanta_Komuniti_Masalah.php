<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Masalah extends Model
{
    protected $table = "krt__kanta_komuniti_masalah";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'masalah_tajuk',
                            'masalah_perincian',
                            'masalah_pelaksanaan',
                            'masalah_penjelasan'
                        ];
}

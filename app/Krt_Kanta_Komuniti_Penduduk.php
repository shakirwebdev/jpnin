<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Penduduk extends Model
{
    protected $table = "krt__kanta_komuniti_penduduk";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'kaum_id',
                            'bilangan_rumah'
                        ];
}

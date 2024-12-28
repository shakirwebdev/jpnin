<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_KesJenayah extends Model
{
    protected $table = "krt__kes_jenayah";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'ref_jenayahID', 
                        ];
}

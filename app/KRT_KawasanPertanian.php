<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_KawasanPertanian extends Model
{
    protected $table = "krt__kawasan_pertanian";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'ref_pertanianID', 
                            'kawasan_pertanian_dalam',
                            'kawasan_pertanian_luar'
                        ];
}

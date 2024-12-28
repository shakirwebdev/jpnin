<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_masalahSosial extends Model
{
    protected $table = "krt__masalah_sosial";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'ref_masalahSosialID', 
                        ];
}

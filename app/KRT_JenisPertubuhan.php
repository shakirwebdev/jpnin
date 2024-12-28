<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_JenisPertubuhan extends Model
{
    protected $table = "krt__jenis_pertubuhan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'jenis_pertubuhan_id', 
                        ];
}

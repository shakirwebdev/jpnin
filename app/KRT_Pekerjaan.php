<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Pekerjaan extends Model
{
    protected $table = "krt__pekerjaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'profession_id', 
                            'pekerjaan_peratus'
                        ];
}

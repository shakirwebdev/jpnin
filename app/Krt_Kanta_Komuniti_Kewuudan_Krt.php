<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Kewuudan_Krt extends Model
{
    protected $table = "krt__kanta_komuniti_kewujudan_krt";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'krt_profile_id',
                            'krt_masalah'
                        ];
}

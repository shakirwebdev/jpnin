<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Peronda extends Model
{
    protected $table = "srs__senarai_peronda";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profile_id', 
                            'peronda_nama', 
                            'peronda_kad'
                        ];
}

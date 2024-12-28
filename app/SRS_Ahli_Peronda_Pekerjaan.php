<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Ahli_Peronda_Pekerjaan extends Model
{
    protected $table = "srs__ahli_peronda_pekerjaan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profile_id', 
                            'ref_profession_id', 
                        ];
}

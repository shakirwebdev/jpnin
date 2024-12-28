<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Ahli_Peronda_Pendidikan extends Model
{
    protected $table = "srs__ahli_peronda_pendidikan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profileID', 
                            'ref_pendidikanID', 
                        ];
}

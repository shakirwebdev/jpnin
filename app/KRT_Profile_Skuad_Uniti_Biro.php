<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Skuad_Uniti_Biro extends Model
{
    protected $table = "krt__profile_skuad_uniti_biro";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'skuad_uniti_id', 
                            'biro_nama', 
                            'biro_nama_penuh', 
                            'biro_ic',
                            'biro_phone',
                            'biro_emel',
                            'biro_pekerjaan',
                        ];
}

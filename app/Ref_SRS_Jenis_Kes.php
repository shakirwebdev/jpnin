<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SRS_Jenis_Kes extends Model
{
    protected $table = "ref__srs_jenis_kes";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kategori_id', 
                            'jenis_description', 
                            'status'
                        ];
}

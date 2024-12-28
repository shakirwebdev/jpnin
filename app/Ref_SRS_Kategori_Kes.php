<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SRS_Kategori_Kes extends Model
{
    protected $table = "ref__srs_kategori_kes";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kategori_description', 
                            'status'
                        ];
}

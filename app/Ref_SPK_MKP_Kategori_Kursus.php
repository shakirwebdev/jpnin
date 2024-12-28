<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_MKP_Kategori_Kursus extends Model
{
    protected $table = "ref__spk_mkp_kategori_kursus";
    protected $primaryKey = 'id';
    protected $fillable = ['kursus_description','status'];
}

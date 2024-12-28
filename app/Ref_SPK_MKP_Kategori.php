<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_MKP_Kategori extends Model
{
    protected $table = "ref__spk_mkp_kategori";
    protected $primaryKey = 'id';
    protected $fillable = ['kategori_description','status'];
}

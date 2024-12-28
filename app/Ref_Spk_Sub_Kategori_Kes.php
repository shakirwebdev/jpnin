<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Spk_Sub_Kategori_Kes extends Model
{
    protected $table = "ref__spk_sub_kategori_kes";
    protected $primaryKey = 'id';
    protected $fillable = ['sub_kategori_description','status'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Spk_Kategori_Kes extends Model
{
    protected $table = "ref__spk_kategori_kes";
    protected $primaryKey = 'id';
    protected $fillable = ['kategori_description','status'];
}

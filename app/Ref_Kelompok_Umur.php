<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Kelompok_Umur extends Model
{
    protected $table = "ref__kelompok_umur";
    protected $primaryKey = 'id';
    protected $fillable = ['umur_description', 'status'];
}

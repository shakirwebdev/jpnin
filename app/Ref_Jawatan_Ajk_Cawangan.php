<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Jawatan_Ajk_Cawangan extends Model
{
    protected $table = "ref__jawatan_ajk_cawangan";
    protected $primaryKey = 'id';
    protected $fillable = ['jawatan_description','status'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Jawatan_Ajk_KRT extends Model
{
    protected $table = "ref__jawatan_ajk_krt";
    protected $primaryKey = 'id';
    protected $fillable = ['jawatan_description','jawatan_status'];
}

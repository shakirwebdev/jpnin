<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_KRT_Cawangan extends Model
{
    protected $table = "ref__krt_cawangan";
    protected $primaryKey = 'id';
    protected $fillable = ['cawangan_description', 'status'];
}

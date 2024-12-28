<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Sumbangan extends Model
{
    protected $table = "ref__sumbangan";
    protected $primaryKey = 'id';
    protected $fillable = ['sumbangan_description', 'status'];
}

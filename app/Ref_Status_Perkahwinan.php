<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Status_Perkahwinan extends Model
{
    protected $table = "ref__status_perkahwinan";
    protected $primaryKey = 'id';
    protected $fillable = ['perkahwinan_description','status'];
}

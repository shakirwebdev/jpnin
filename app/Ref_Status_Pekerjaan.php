<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Status_Pekerjaan extends Model
{
    protected $table = "ref__status_pekerjaan";
    protected $primaryKey = 'id';
    protected $fillable = ['pekerjaan_description','status'];
}

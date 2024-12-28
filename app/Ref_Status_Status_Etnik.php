<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Status_Status_Etnik extends Model
{
    protected $table = "ref__status_etnik";
    protected $primaryKey = 'id';
    protected $fillable = ['status_etnik_description','status'];
}

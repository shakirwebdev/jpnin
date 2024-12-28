<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Teras extends Model
{
    protected $table = "ref__aktiviti_teras";
    protected $primaryKey = 'id';
    protected $fillable = ['teras_description', 'status'];
}

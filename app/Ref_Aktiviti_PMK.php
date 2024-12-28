<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_PMK extends Model
{
    protected $table = "ref__aktiviti_pmk";
    protected $primaryKey = 'id';
    protected $fillable = ['pmk_description', 'status'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Jenis_Aktiviti extends Model
{
    protected $table = "ref__jenis_aktiviti";
    protected $primaryKey = 'id';
    protected $fillable = ['aktiviti_description', 'status'];
}

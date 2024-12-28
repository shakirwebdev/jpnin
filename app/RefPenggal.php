<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefPenggal extends Model
{
    protected $table = "ref__penggal";
    protected $primaryKey = 'id';
    protected $fillable = ['penggal_mula','penggal_tamat','status'];
}
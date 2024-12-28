<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Bahagian extends Model
{
    protected $table = "ref__aktiviti_bahagian";
    protected $primaryKey = 'id';
    protected $fillable = ['bahagian_description', 'status'];
}

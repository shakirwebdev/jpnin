<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Sumber_Kewangan extends Model
{
    protected $table = "ref__aktiviti_sumber_kewangan";
    protected $primaryKey = 'id';
    protected $fillable = ['kewangan_description', 'status'];
}

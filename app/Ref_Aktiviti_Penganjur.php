<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Penganjur extends Model
{
    protected $table = "ref__aktiviti_penganjur";
    protected $primaryKey = 'id';
    protected $fillable = ['penganjur_description', 'status'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Penganjur extends Model
{
    protected $table = "ref__penganjur";
    protected $primaryKey = 'id';
    protected $fillable = ['penganjur_description','penganjur_status'];
}

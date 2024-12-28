<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Status_Warganegara extends Model
{
    protected $table = "ref__status_warganegara";
    protected $primaryKey = 'id';
    protected $fillable = ['warganegara_description','status'];
}


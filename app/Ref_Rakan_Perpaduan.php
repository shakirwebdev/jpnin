<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Rakan_Perpaduan extends Model
{
    protected $table = "ref__rakan_perpaduan";
    protected $primaryKey = 'id';
    protected $fillable = ['rakan_description', 'status'];
}

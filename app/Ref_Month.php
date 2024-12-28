<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Month extends Model
{
    protected $table = "ref__month";
    protected $primaryKey = 'id';
    protected $fillable = ['month_description','status'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Agama extends Model
{
    protected $table = "ref__agama";
    protected $primaryKey = 'id';
    protected $fillable = ['agama_description'];
}

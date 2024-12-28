<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefKaum extends Model
{
    protected $table = "ref__kaum";
    protected $primaryKey = 'id';
    protected $fillable = ['kaum_description'];
}

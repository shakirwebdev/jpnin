<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefPendidikan extends Model
{
    protected $table = "ref__pendidikan";
    protected $primaryKey = 'id';
    protected $fillable = ['pendidikan_description','pendidikan_status'];
}

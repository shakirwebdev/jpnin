<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefPertanian extends Model
{
    protected $table = "ref__pertanian";
    protected $primaryKey = 'id';
    protected $fillable = ['pertanian', 'pertanian_description'];
}

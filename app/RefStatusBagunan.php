<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefStatusBagunan extends Model
{
    protected $table = "ref__status_bagunan";
    protected $primaryKey = 'id';
    protected $fillable = ['status_bagunan_description', 'status'];
}

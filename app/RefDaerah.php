<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefDaerah extends Model
{
    protected $table = "ref__daerahs";
    protected $primaryKey = 'id';
    protected $fillable = ['daerah_id', 'daerah_description', 'state_id'];
}

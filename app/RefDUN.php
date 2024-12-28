<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefDUN extends Model
{
    protected $table = "ref__duns";
    protected $primaryKey = 'id';
    protected $fillable = ['dun_id', 'dun_description', 'parlimen_id', 'state_id'];
}
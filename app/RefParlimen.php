<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefParlimen extends Model
{
    protected $table = "ref__parlimens";
    protected $primaryKey = 'id';
    protected $fillable = ['parlimen_id', 'parlimen_description', 'state_id'];
}

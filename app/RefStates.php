<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefStates extends Model
{
    protected $table = "ref__states";
    protected $primaryKey = 'id';
    protected $fillable = ['state_id', 'state_abbr', 'state_description', 'status'];
}

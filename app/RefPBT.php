<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefPBT extends Model
{
    protected $table = "ref__pbts";
    protected $primaryKey = 'id';
    protected $fillable = ['pbt_id', 'pbt_description', 'state_id'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefBandar extends Model
{
    protected $table = "ref__bandars";
    protected $primaryKey = 'id';
    protected $fillable = ['bandar_description', 'daerah_id', 'state_id'];
}

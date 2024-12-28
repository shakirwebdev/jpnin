<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Strategi extends Model
{
    protected $table = "ref__aktiviti_strategi";
    protected $primaryKey = 'id';
    protected $fillable = ['strategi_description', 'status'];
}

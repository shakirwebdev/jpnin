<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Peringkat extends Model
{
    protected $table = "ref__aktiviti_peringkat";
    protected $primaryKey = 'id';
    protected $fillable = ['peringkat_description', 'status'];
}

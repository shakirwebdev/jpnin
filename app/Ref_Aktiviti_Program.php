<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Program extends Model
{
    protected $table = "ref__aktiviti_program";
    protected $primaryKey = 'id';
    protected $fillable = ['agenda_id', 'program_description', 'status'];
}

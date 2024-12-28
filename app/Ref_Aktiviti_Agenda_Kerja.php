<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Agenda_Kerja extends Model
{
    protected $table = "ref__aktiviti_agenda_kerja";
    protected $primaryKey = 'id';
    protected $fillable = ['agenda_description', 'status'];
}

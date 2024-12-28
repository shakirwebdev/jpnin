<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJenisRumah extends Model
{
    protected $table = "ref__jenis_rumah";
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_rumah', 'jenis_rumah_description'];
}

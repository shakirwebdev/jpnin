<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJenisPertubuhan extends Model
{
    protected $table = "ref__jenis_pertubuhan";
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_pertubuhan', 'jenis_pertubuhan_description'];
}

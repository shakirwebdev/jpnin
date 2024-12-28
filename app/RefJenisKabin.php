<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJenisKabin extends Model
{
    protected $table = "ref__jenis_kabin";
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_kabin_description', 'status'];
}

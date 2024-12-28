<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJenisPremis extends Model
{
    protected $table = "ref__jenis_premis";
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_premis_description', 'status'];
}

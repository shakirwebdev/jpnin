<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJantina extends Model
{
    protected $table = "ref__jantina";
    protected $primaryKey = 'id';
    protected $fillable = ['jantina_description'];
}

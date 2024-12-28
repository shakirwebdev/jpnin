<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefProfession extends Model
{
    protected $table = "ref__profession";
    protected $primaryKey = 'id';
    protected $fillable = ['profession', 'profession_description'];
}

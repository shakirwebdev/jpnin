<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefKemudahanAwam extends Model
{
    protected $table = "ref__kemudahan_awam";
    protected $primaryKey = 'id';
    protected $fillable = ['kemudahan_awam', 'kemudahan_awam_description'];
}

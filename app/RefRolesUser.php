<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefRolesUser extends Model
{
    protected $table = "ref__roles_users";
    protected $primaryKey = 'id';
    protected $fillable = ['short_description', 'long_description'];

    public function users(){
        return $this->hasMany('App\User', 'id');
    }
}

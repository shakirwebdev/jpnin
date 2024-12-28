<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = "users__profile";
    protected $primaryKey = 'id';
    protected $fillable = [
                        'user_id', 
                        'user_fullname', 
                        'no_ic', 
                        'no_phone', 
                        'state_id', 
                        'daerah_id',
                        'krt_id'];

    public function profile(){
        return $this->hasMany('App\User', 'user_id');
    }

    public function users(){
        return $this->hasMany('App\User', 'user_id');
    }    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    protected $primaryKey = 'user_id';
    protected $fillable = [
                            'no_ic', 
                            'user_email', 
                            
                         
                        ];
}
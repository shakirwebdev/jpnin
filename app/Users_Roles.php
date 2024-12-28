<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_Roles extends Model
{
    protected $table = "users__roles";
    protected $primaryKey = 'id';
    protected $fillable = [
                        'user_id', 
                        'role_id', 
                        'status'
                        ];

    
}

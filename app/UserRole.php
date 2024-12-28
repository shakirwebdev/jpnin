<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = "users__roles";
    protected $primaryKey = 'id';
    protected $fillable = [
                        'id', 
                        'user_id', 
                        'role_id', 
                        'status'];
}

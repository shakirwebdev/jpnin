<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefRolesMenu extends Model
{
    protected $table = "ref__roles_menus";
    protected $primaryKey = 'id';
    protected $fillable = ['url', 'nama'];
}

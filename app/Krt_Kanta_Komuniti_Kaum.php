<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Kaum extends Model
{
    protected $table = "krt__kanta_komuniti_kaum";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'kaum_id',
                            'bilangan'
                        ];
}

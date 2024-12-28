<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Pemimpin extends Model
{
    protected $table = "krt__kanta_komuniti_pemimpin";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'pemimpin_nama',
                            'pemimpin_catatan'
                        ];
}

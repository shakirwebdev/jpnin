<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti_Risiko extends Model
{
    protected $table = "krt__kanta_komuniti_risiko";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'kanta_komuniti_id', 
                            'risiko_nama_agensi',
                            'risiko_jenis',
                            'risiko_isu'
                        ];
}

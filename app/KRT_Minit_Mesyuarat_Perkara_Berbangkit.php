<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Minit_Mesyuarat_Perkara_Berbangkit extends Model
{
    protected $table = "krt__minit_mesyuarat_perkara_berbangkit";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_minit_mesyuarat_id', 
                            'berbangkit_perkara', 
                            'berbangkit_tindakan'
                        ];
}

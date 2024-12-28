<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Sejiwa_Perkhidmatan extends Model
{
    protected $table = "krt__profile_sejiwa_perkhidmatan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'sejiwa_id',
                            'perkhidmatan_sejiwa_keperluan', 
                            'perkhidmatan_sejiwa_perkhidmatan', 
                            'perkhidmatan_sejiwa_kerjasama'
                        ];
}

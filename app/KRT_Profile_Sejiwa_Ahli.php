<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Sejiwa_Ahli extends Model
{
    protected $table = "krt__profile_sejiwa_ahli";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'sejiwa_id',
                            'ahli_sejiwa_nama', 
                            'ahli_sejiwa_ic', 
                            'ahli_sejiwa_pekerjaan',
                            'kaum_id',
                            'ahli_sejiwa_jawatan'
                        ];
}

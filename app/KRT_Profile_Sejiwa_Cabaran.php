<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Sejiwa_Cabaran extends Model
{
    protected $table = "krt__profile_sejiwa_cabaran";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'sejiwa_id',
                            'cabaran_sejiwa_cabaran', 
                            'cabaran_sejiwa_mengatasi'
                        ];
}

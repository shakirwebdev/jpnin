<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_ikes_bilangan_cedera_parah extends Model
{
    protected $table = "spk__ikes_bilangan_cedera_parah";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_ikes_id', 
                            'kaum_id', 
                            'jumlah_cedera_parah'
                        ];
}

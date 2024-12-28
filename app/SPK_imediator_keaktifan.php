<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imediator_keaktifan extends Model
{
    protected $table = "spk__imediator_keaktifan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imediator_id', 
                            'status', 
                            'dihantar_by',
                            'dihantar_date',
                            'disokong_by',
                            'disokong_date',
                            'disokong_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                        ];
}

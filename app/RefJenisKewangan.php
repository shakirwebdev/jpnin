<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefJenisKewangan extends Model
{
    protected $table = "ref__jenis_kewangan";
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_kewangan_description',
                            'status'
                        ];
    
}

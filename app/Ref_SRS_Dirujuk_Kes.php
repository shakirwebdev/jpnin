<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SRS_Dirujuk_Kes extends Model
{
    protected $table = "ref__srs_dirujuk_kes";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'rujuk_description', 
                            'status'
                        ];
}

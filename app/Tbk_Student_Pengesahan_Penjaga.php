<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbk_Student_Pengesahan_Penjaga extends Model
{
    protected $table = "tbk__student_pengesahan_penjaga";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'tbk_student_id', 
                            'ref_pengesahan_id', 
                        ];
}

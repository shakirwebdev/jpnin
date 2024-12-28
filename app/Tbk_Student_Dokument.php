<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbk_Student_Dokument extends Model
{
    protected $table = "tbk__student_dokument";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'tbk_student_id', 
                            'file_title', 
                            'file_dokument'
                        ];
}

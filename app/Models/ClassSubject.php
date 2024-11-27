<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function classes(){
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    public function subjects(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

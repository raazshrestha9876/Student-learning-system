<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'class_subjects', 'class_id', 'subject_id');
    }
    public function students(){
        return $this->hasMany(User::class, 'class_id');
    }
    public function teachers(){
        return $this->belongsToMany(User::class, 'teacher_classes', 'teacher_id', 'class_id');
    }
    public function assignments() {
        return $this->hasManyThrough(Assignment::class, TeacherClass::class, 'class_id', 'teacher_classes_id');
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'class_id'); 
    }

}

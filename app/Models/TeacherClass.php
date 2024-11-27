<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    use HasFactory;
    protected $fillable = ['class_id', 'subject_id', 'teacher_id'];

    public function teachers()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function classesAsTeacher()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_classes_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'class_id', 'status'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

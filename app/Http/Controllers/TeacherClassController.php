<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\TeacherClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeacherClassController extends Controller
{
    public function List()
    {
        $teacher_classes = TeacherClass::with(['classesAsTeacher', 'teachers', 'subject'])->paginate(10);
        return view('admin.teacher_class.list', compact('teacher_classes'));
    }
    public function Add()
    {
        $classes = ClassModel::all();
        $teachers = User::where('is_role', 2)->get();
        return view('admin.teacher_class.add', compact('classes', 'teachers'));
    }
    public function Create(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_ids' => [
                'required',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    foreach ($value as $teacher_id) {
                        $exists = TeacherClass::where('class_id', $request->class_id)
                            ->where('teacher_id', $teacher_id)
                            ->where('subject_id', $request->subject_id)
                            ->exists();
                        if ($exists) {
                            $fail("The teacher id $teacher_id is already assigned to the class with subject id {$request->subject_id}.");
                        }
                    }
                }
            ]
        ]);

        $teacher_classes = [];
        foreach ($request->teacher_ids as $teacher_id) {
            $teacher_class = new TeacherClass();
            $teacher_class->class_id = $request->class_id;
            $teacher_class->subject_id = $request->subject_id;
            $teacher_class->teacher_id = $teacher_id;
            $teacher_class->save();
            $teacher_classes[] = $teacher_class;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Assigning class to teacher successfully',
                'teacher_classes' => $teacher_classes
            ]);
        }

        return redirect('admin.teacher_class.list')->with('success', 'Assigning class to teacher successfully');
    }


    public function getSubjects($classId)
    {
        $class = ClassModel::with('subjects')->find($classId);
        return response()->json(['subjects' => $class ? $class->subjects : []]);
    }


    public function Delete($id)
    {
        $teacher_class = TeacherClass::find($id);
        $teacher_class->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function timeline()
    {
        // Get the teacher's classes along with their subjects
        $teacher_classes = TeacherClass::with(['classesAsTeacher', 'subject'])
            ->where('teacher_id', Auth::user()->id)
            ->get();

        return view('teacher.timeline', ["teacher_classes" => $teacher_classes]);
    }
}

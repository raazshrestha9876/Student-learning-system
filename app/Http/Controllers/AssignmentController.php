<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function List()
    {
        $assignments = Assignment::with(['teacherClass.classesAsTeacher', 'teacherClass.subject'])
            ->whereHas('teacherClass', function ($query) {
                $query->where('teacher_id', Auth::user()->id);
            })
            ->get();

        return view('teacher.assignment.list', compact('assignments'));
    }

    public function Add()
    {
        $teacher_classes = TeacherClass::with('classesAsTeacher', 'subject')
            ->where('teacher_id', Auth::user()->id)->get();

        return view('teacher.assignment.add', compact('teacher_classes'));
    }

    public function Create(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'subject_id' => 'required|exists:subjects,id', 
            'submission_date' => 'required|date',
            'document' => 'required|file|mimes:pdf,doc,docx', 
            'description' => 'required|string|max:500',
        ]);

        $assignment = new Assignment();
        $assignment->teacher_classes_id = TeacherClass::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('teacher_id', Auth::user()->id)
            ->first()
            ->id;

        $assignment->submission_date = $request->submission_date;
        $assignment->description = $request->description;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/documents/'), $filename);
            $assignment->document = $filename;
        }

        $assignment->save();

        return redirect('teacher.assignment.list')->with('success', 'Assignment created successfully.');
    }

    public function Delete($id)
    {
        $assignment = Assignment::find($id);
        $assignment->delete();
        return back()->with('success', 'Assignment deleted successfully');
    }

    public function getSubjects($classId)
    {
        $teacherId = Auth::user()->id;
        $subjects = TeacherClass::where('class_id', $classId)
            ->where('teacher_id', $teacherId)
            ->with('subject')
            ->get()
            ->pluck('subject')
            ->filter();

        return response()->json(['subjects' => $subjects]);
    }
    
}

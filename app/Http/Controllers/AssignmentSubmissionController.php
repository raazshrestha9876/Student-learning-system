<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentSubmissionController extends Controller
{

    public function submissionForm($assignmentId)
    {
        $assignment = Assignment::with('teacherClass.subject', 'teacherClass.classesAsTeacher')
            ->where('id', $assignmentId)
            ->first();

        return view('student.assignment.assignmentSubmission', compact('assignment'));
    }

    public function storeSubmission(Request $request, $assignmentId)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $studentId = Auth::user()->id;

        // Check if the student is in the class of the assignment
        $assignment = Assignment::findOrFail($assignmentId);
        $studentInClass = ClassModel::whereHas('students', function ($query) use ($studentId) {
            $query->where('id', $studentId);
        })->where('id', $assignment->teacherClass->class_id)->exists();

        if (!$studentInClass) {
            return redirect()->back()->with('error', 'You are not enrolled in this class.');
        }

        if ($request->hasFile('submission_file')) {
            $file = $request->file('submission_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/documents/'), $filename);

            AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'student_id' => $studentId,
                'submission_file' => $filename
            ]);

            return back()->with('success', 'Assignment submitted successfully.');
        }
    }

    public function viewSubmissions($assignmentId)
    {
        $assignment = Assignment::with([
            'submissions.student',
            'teacherClass.classesAsTeacher'
        ])->findOrFail($assignmentId);

        return view('teacher.assignment.submission', compact('assignment'));
    }
}

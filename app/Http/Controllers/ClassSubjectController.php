<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Subject;
use Illuminate\Http\Request;


class ClassSubjectController extends Controller
{
    public function List()
    {
        $class_subjects = ClassSubject::with(['classes', 'subjects'])->paginate(10);
        return view('admin.class_subject.list', compact('class_subjects'));
    }
    public function Add()
    {
        $classes = ClassModel::all();
        $subjects = Subject::all();
        return view('admin.class_subject.add', compact('classes', 'subjects'));
    }
    public function Create(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'subject_ids' => [
                'required',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    foreach ($value as $subject_id) {
                        $exists = ClassSubject::where('class_id', $request->class_id)
                            ->where('subject_id', $subject_id)
                            ->exists();
                        if ($exists) {
                            $fail("The subject id $subject_id is already assigned to the class.");
                        }
                    }
                },
            ],
        ]);

        $class_subjects = [];

        foreach ($request->subject_ids as $subject_id) {
            $class_subject = new ClassSubject();
            $class_subject->class_id = $request->class_id;
            $class_subject->subject_id = $subject_id;
            $class_subject->save();
            $class_subjects[] = $class_subject;
        }

        if ($request->expectsJson()) {
            return response()->json([
                "success" => true,
                "message" => "Assigning subject(s) to class successfully",
                "class_subjects" => $class_subjects
            ]);
        }

        return redirect()->route('admin.class_subject.list')->with('success', 'Assigning subject(s) to class successfully');
    }

    public function Edit($id)
    {
        $class_subject = ClassSubject::find($id);
        $classes = ClassModel::all();
        $subjects = Subject::all();
        return view('admin.class_subject.edit', compact('class_subject', 'classes', 'subjects'));
    }
    public function Update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'subject_ids' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    foreach ($value as $subject_id) {
                        $exists = ClassSubject::where('class_id', $request->class_id)
                            ->where('subject_id', $subject_id)
                            ->exists();
                        if ($exists) {
                            $fail("The subject id $subject_id is already assigned to the class.");
                        }
                    }
                },
            ],
        ]);

        $class_subjects = [];

        $class_subject = ClassSubject::find($id);
        
        //updating existing record by id
        if ($class_subject) {
            $class_subject->class_id = $request->class_id;
            $class_subject->subject_id = $request->subject_ids[0]; //existing subject id from the first index of the subject_ids array
            $class_subject->update();
            $class_subjects[] = $class_subject;
        }
        //insert additional record from the second index of the subject_ids array
        for ($i = 1; $i < count($request->subject_ids); $i++) {
            $class_subject = new ClassSubject();
            $class_subject->class_id = $request->class_id;
            $class_subject->subject_id = $request->subject_ids[$i];
            $class_subject->save();
            $class_subjects[] = $class_subject;
        }

        if ($request->expectsJson()) {
            return response()->json([
                "success" => true,
                "message" => "updating subject to class successfully",
                "class_subject" => $class_subject
            ]);
        };
        return redirect('admin.class_subject.list')->with('success', 'updating subject to class successfully');
    }
    public function Delete($id)
    {
        $class_subject = ClassSubject::find($id);
        $class_subject->delete();
        return back()->with("success", 'Deleting subject to the class');
    }
}

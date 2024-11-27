<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function List(Request $request)
    {
        $subjects = Subject::orderBy('id');
        if (!empty($request->get('name'))) {
            $subjects->where('name', 'like', '%' . $request->get('name') . '%');
        }
        if (!empty($request->get('type'))) {
            $subjects->where('type', 'like', '%' . $request->get('type') . '%');
        }
        $subjects = $subjects->paginate(10);
        return view('admin.subject.list', compact('subjects'));
    }
    public function Add()
    {
        return view('admin.subject.add');
    }
    public function Create(Request $request)
    {

        $request->validate([
            "name" => "required|string|max:20|unique:subjects,name",
            "credit_hour" => "required|integer"
        ]);

        $subject = new Subject();
        $subject->name = trim($request->name);
        $subject->type = trim($request->type);
        $subject->credit_hour = trim($request->credit_hour);
        $subject->status = trim($request->status);
        $subject->save();

        if ($request->expectsJson()) {
            return response()->json([
                "success" => true,
                "message" => "Subject Added succesfully",
                "subject" => $subject
            ]);
        };
    }
    public function Edit($id)
    {
        $subject = Subject::find($id);
        return view('admin.subject.edit', ['subject' => $subject]);
    }
    public function Update(Request $request, $id)
    {

        $request->validate([
            "name" => "nullable|string|max:20|unique:subjects,name,".$id,
            "credit_hour" => "nullable|integer"
        ]
    );
        $subject = Subject::find($id);
        $subject->name = trim($request->name);
        $subject->type = trim($request->type);
        $subject->credit_hour = trim($request->credit_hour);
        $subject->status = trim($request->status);
        $subject->update();

        if ($request->expectsJson()) {
            return response()->json([
                "success" => true,
                "message" => "Subject Added succesfully",
                "subject" => $subject
            ]);
        };

        return redirect('admin.subject.list')->with('success', 'Subject Added successfully');
    }
    public function Delete($id)
    {
        $subject = Subject::find($id);
        $subject->delete();
        return back()->with('success', 'Subject Deleted Successfully');
    }
}

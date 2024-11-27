<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function List()
    {
        $students = User::where('is_role', 3)->with('classAsStudent')->paginate(10);
        return view('admin.student.list', compact('students'));
    }

    public function Add()
    {
        $classes = ClassModel::all();
        return view('admin.student.add', compact('classes'));
    }
    public function Create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'required|string|max:50',
            'phone_no' => 'required|digits_between:8,15',
            'admission_no' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'address' => 'required|string|max:50',
            'gender' => 'required'
            // 'class_id' => 'required|exists:classes,id',
        ]);

        $student = new User();
        $student->name = trim($request->name);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = $randomStr . '.' . $ext;
            $file->move(public_path('upload/images/'), $filename);
            $student->profile_pic = $filename;
        }

        $student->roll_no = trim($request->roll_no);
        $student->dob = trim($request->dob);
        $student->class_id = trim($request->class_id);
        $student->phone_no = trim($request->phone_no);
        $student->admission_no = trim($request->admission_no);
        $student->admission_date = trim($request->admission_date);
        $student->status = trim($request->status);
        $student->email = trim($request->email);
        $student->address = trim($request->address);
        $student->gender = trim($request->gender);
        $student->is_role = 3;
        $student->password = Hash::make($request->password);

        $student->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student added successfully',
                'student' => $student
            ]);
        }
        return redirect('admin.student.list')->with('success', 'Student added successfully');
    }
    public function Edit($id)
    {

        $classes = ClassModel::all();
        $student = User::find($id);
        return view('admin.student.edit', compact('classes', 'student'));
    }
    public function Update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'required|string|max:50',
            'phone_no' => 'required|digits_between:8,15',
            'admission_no' => 'required|string|max:50',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'address' => 'required|string|max:50',
            'gender' => 'required'
            // 'class_id' => 'required|exists:classes,id',
        ]);

        $student = User::find($id);
        $student->name = trim($request->name);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = $randomStr . '.' . $ext;
            $file->move(public_path('upload/images/'), $filename);
            $student->profile_pic = $filename;
        }

        $student->roll_no = trim($request->roll_no);
        $student->dob = trim($request->dob);
        $student->class_id = trim($request->class_id);
        $student->phone_no = trim($request->phone_no);
        $student->admission_no = trim($request->admission_no);
        $student->admission_date = trim($request->admission_date);
        $student->status = trim($request->status);
        $student->email = trim($request->email);
        $student->address = trim($request->address);
        $student->gender = trim($request->gender);
        $student->password = Hash::make($request->password);

        $student->update();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'student' => $student
            ]);
        }
        return redirect('admin.student.list')->with('success', 'Student updated successfully');
    }
    public function Delete($id)
    {
        $student = User::find($id);
        $student->delete();
        return back()->with('success', 'Student deleted successfully');
    }

    public function profileShow()
    {
        $student = User::find(Auth::User()->id);
        return view('student.profile', ["student" => $student]);
    }

    public function assignment()
    {
        $studentId = Auth::user()->id;

        // Fetch classes for the student
        $classes = ClassModel::whereHas('students', function ($query) use ($studentId) {
            $query->where('id', $studentId);
        })->with('subjects', 'assignments')->get();

        // Retrieve assignments for those classes
        $assignments = [];
        foreach ($classes as $class) {
            foreach ($class->assignments as $assignment) {
                $assignments[] = $assignment;
            }
        }

        return view('student.assignment.assignment', compact('assignments'));
    }
}

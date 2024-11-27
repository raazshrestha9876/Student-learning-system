<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function List()
    {
        $teachers = User::where('is_role', 2)->paginate(10);
        return view('admin.teacher.list', compact('teachers'));
    }
    public function Add()
    {
        return view('admin.teacher.add');
    }

    public function Create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'dob' => 'required',
            'qualification' => 'required',
            'phone_no' => 'required|digits_between:8,15',
            'appointment_date' => 'required',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'password' => 'required|string|min:6',
            'gender' => 'required'

        ]);

        $teacher = new User();
        $teacher->name = trim($request->name);
        $teacher->email = trim($request->email);
        $teacher->password = Hash::make($request->password);
        $teacher->dob = trim($request->dob);
        $teacher->phone_no = trim($request->phone_no);
        $teacher->status = trim($request->status);
        $teacher->is_role = 2;
        $teacher->appointment_date = trim($request->appointment_date);
        $teacher->qualification = trim($request->qualification);
        $teacher->address = trim($request->address);
        $teacher->gender = trim($request->gender);


        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10); 
            $filename = $randomStr . '.' . $ext;
            $file->move(public_path('upload/images/'), $filename); 
            $teacher->profile_pic = $filename;
        }

        $teacher->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Teacher added successfully',
                'success' => true,
                'teacher' => $teacher
            ]);
        };
        return redirect('admin.teacher.list')->with('success', 'student added successfully');
    }

    public function Edit($id){
        $teacher = User::find($id);
        return view("admin.teacher.edit", ["teacher" => $teacher]); 
    }

    public function Update(Request $request, $id){

        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email',
            'dob' => 'required',
            'qualification' => 'required',
            'phone_no' => 'required|digits_between:8,15',
            'appointment_date' => 'required',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'password' => 'required|string|min:6',
            'gender' => 'required'

        ]);

        $teacher = User::find($id);
        $teacher->name = trim($request->name);
        $teacher->email = trim($request->email);
        $teacher->password = Hash::make($request->password);
        $teacher->dob = trim($request->dob);
        $teacher->phone_no = trim($request->phone_no);
        $teacher->status = trim($request->status);
        $teacher->appointment_date = trim($request->appointment_date);
        $teacher->qualification = trim($request->qualification);
        $teacher->address = trim($request->address);
        $teacher->gender = trim($request->gender);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10); 
            $filename = $randomStr . '.' . $ext;
            $file->move(public_path('upload/images/'), $filename); 
            $teacher->profile_pic = $filename;
        }

        $teacher->update();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Teacher updated successfully',
                'success' => true,
                'teacher' => $teacher
            ]);
        };
        return redirect('admin.teacher.list')->with('success', 'Teacher updated successfully');
        

    }
    public function Delete($id){
        $teacher = User::find($id);
        $teacher->delete();
        return back()->with('success', 'Teacher deleted successfully');
    }

    public function profileShow() {
        $teacher = User::find(Auth::user()->id);
        return view('teacher.profile', ['teacher' => $teacher]);
    }
    
       
}

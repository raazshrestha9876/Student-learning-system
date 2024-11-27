<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function List(Request $request)
    {
        // $data = [
        //     'title' => 'admin-list'
        // ];
        //also need to pass to the template using $data
        $users = User::where('is_role', 1);
        if(!empty($request->name))
        {
            $users->where('name', 'like', '%'.$request->name.'%');
        }
        if(!empty($request->email)){
            $users->orWhere('email', 'like', '%'.$request->email.'%');

        }
        $users = $users->paginate(10);
       
        return view('admin.admin.list', compact('users'));
    }

    public function Add()
    {
        return view('admin.admin.add');
    }
    public function Create(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:20",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:8",
            "phone_no" => "required|digits_between:8,15",
            "dob" => "required",
            "address" => "required",
            "profile_pic" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->phone_no = trim($request->phone_no);
        $user->dob = trim($request->dob);
        $user->gender = trim($request->gender);
        $user->address = trim($request->address);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10); 
            $filename = $randomStr . '.' . $ext;
            $file->move(public_path('upload/images/'), $filename); 
            $user->profile_pic = $filename;
        }
        $user->is_role = 1;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin successfully created',
                'user' => $user
            ], 201);
        }

        return redirect('admin/admin/list')->with('success', 'Admin successfully created');
    }
    public function Edit($id)
    {
        $user = User::find($id);
        return view('admin.admin.edit', ['user' => $user]);
    }
    public function Update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|max:20",
            "email" => "required|email",
            "password" => "required|string|min:8",
            "phone_no" => "required|digits_between:8,15",
            "dob" => "required",
            "address" => "required",
            "profile_pic" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        $user = User::find($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->phone_no = trim($request->phone_no);
        $user->dob = trim($request->dob);
        $user->gender = trim($request->gender);
        $user->address = trim($request->address);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10); 
            $filename = $randomStr . '.' . $ext;
            $file->move(public_path('upload/images/'), $filename); 
            $user->profile_pic = $filename;
        }
        $user->update();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin successfully updated',
                'user' => $user
            ], 201);
        }

        return redirect('admin/admin/list')->with('success', 'Admin successfully created');
    }
    public function Delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('success', 'Admin delete successfully');
    }
}

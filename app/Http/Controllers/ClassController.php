<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function List(Request $request)
    {
        $classes = ClassModel::orderBy('id');
        if ($request->get('name')) {
            $classes->where('name', 'like', '%' . $request->get('name') . '%');
        }
        $classes = $classes->paginate(10);
        return view('admin.class.list', compact('classes'));
    }
    public function Add()
    {
        return view('admin.class.add');
    }
    public function Create(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:40",
        ]);

        $class = new ClassModel();
        $class->name  = trim($request->name);
        $class->status = trim($request->status);
        $class->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'class added successfully',
                'class' => $class
            ]);
        };
        return redirect('admin/class/list')->with('success', 'class added successfully');
    }

    public function Edit($id)
    {
        $class = ClassModel::find($id);
        return view('admin.class.edit', ['class' => $class]);
    }
    public function Update(Request $request, $id)
    {
        $request->validate([
            "name" => "nullable|string|max:40",
        ]);

        $class = ClassModel::find($id);
        $class->name  = trim($request->name);
        $class->status = trim($request->status);
        $class->update();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'class edited successfully',
                'class' => $class
            ]);
        };
        return redirect('admin/class/list')->with('success', 'class edited successfully');
    }
    public function Delete($id)
    {
        $class = ClassModel::find($id);
        $class->delete();
        return back()->with('success', 'class deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{

    public function index()
    {
        $role = Auth::user()->is_role;
        $users = [];
        $className = '';
        $classes = [];

        switch ($role) {
            case 1: // Admin
                $users = User::where('id', '!=', Auth::id())->get();
                $classes = ClassModel::distinct()->get();
                break;

            case 2: // Teacher
                $classIds = Auth::user()->classesAsTeacher->pluck('id')->unique();
                $users = User::whereIn('class_id', $classIds)
                    ->where('is_role', 3) // Only students
                    ->where('id', '!=', Auth::id())
                    ->distinct()
                    ->get();
                $classes = Auth::user()->classesAsTeacher->unique();
                break;

            case 3: // Student
                $classId = Auth::user()->class_id;
                $className = ClassModel::find($classId)->name ?? '';

                // Retrieve students in the same class
                $users = User::where('class_id', $classId)
                    ->where('is_role', 3) // Only students
                    ->where('id', '!=', Auth::id())
                    ->distinct()
                    ->get();

                // Retrieve teachers and admins (optional, if you want them too)
                $teachers = User::whereIn('id', function ($query) use ($classId) {
                    $query->select('teacher_id')
                        ->from('teacher_classes')
                        ->where('class_id', $classId);
                })->distinct()->get();

                $admins = User::where('is_role', 1)
                    ->where('id', '!=', Auth::id())
                    ->distinct()
                    ->get();

                // Combine teachers and admins with students (if needed)
                $users = $users->merge($teachers)->merge($admins)->unique('id')->where('id', '!=', Auth::id());
                $classes = ClassModel::where('id', $classId)->distinct()->get();
                break;
        }

        return view($this->getChatView($role), compact('users', 'classes', 'className'));
    }

    public function showChat($userId)
    {
        $receiver = User::findOrFail($userId);
        $role = Auth::user()->is_role;
        $className = '';
        $messages = [];
        $users = [];
        $classes = [];

        if ($role === 2 && $receiver->is_role === 3) {
            $classIds = Auth::user()->classesAsTeacher->pluck('id')->toArray();
            if (!in_array($receiver->class_id, $classIds)) {
                return redirect()->back()->with('error', 'You can only chat with students from your class.');
            }
        }

        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        if ($role === 2) {
            $classes = Auth::user()->classesAsTeacher;
            $users = User::whereIn('class_id', $classes->pluck('id'))
                ->where('is_role', 3)
                ->where('id', '!=', Auth::id())
                ->distinct()
                ->get();
        } elseif ($role === 3) {
            $classId = Auth::user()->class_id;
            $users = User::where('class_id', $classId)
                ->where('is_role', 3)
                ->where('id', '!=', Auth::id())
                ->get();

            $teachers = User::whereIn('id', function ($query) use ($classId) {
                $query->select('teacher_id')->from('teacher_classes')->where('class_id', $classId);
            })->get();

            $admins = User::where('is_role', 1)->where('id', '!=', Auth::id())->get();
            $users = $users->merge($teachers)->merge($admins);

            $class = ClassModel::find($classId);
            $className = $class ? $class->name : '';

            $classes = ClassModel::where('id', $classId)->get();
        }

        return view($this->getChatView($role), compact('users', 'classes', 'messages', 'receiver', 'className'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240'
        ]);

        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ];

        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->store('chat_files', 'public');
            $data['file'] = $fileName;
        }

        Message::create($data);

        return redirect($this->getChatUrl($request->receiver_id));
    }

    private function getChatView($role)
    {
        return match ($role) {
            1 => 'admin.chat.message',
            2 => 'teacher.chat.message',
            3 => 'student.chat.message',
            default => abort(403, 'Unauthorized action.'),
        };
    }

    private function getChatUrl($receiverId)
    {
        return url('chat/' . $receiverId);
    }

    public function getStudents($id)
    {
        $students = User::where('class_id', $id)->get();
        return response()->json(['students' => $students]);
    }
}

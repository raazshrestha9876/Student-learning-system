<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function createAttendance(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $photoData = $request->input('photo');
        $photoData = str_replace('data:image/jpeg;base64,', '', $photoData);
        $photoData = str_replace(' ', '+', $photoData);
        $image = base64_decode($photoData);

        $photoFileName = uniqid() . '.jpg';
        $photoAbsolutePath = storage_path('app/photos/' . $photoFileName);
        Storage::put('photos/' . $photoFileName, $image);

        $knownFacesDir = public_path('known_faces');
        $pythonScriptPath = public_path('scripts/face_recognition_script.py');

        $command = "python " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($knownFacesDir) . " " . escapeshellarg($photoAbsolutePath);
        $output = shell_exec($command);

        Storage::delete('photos/' . $photoFileName);

        $studentId = trim($output);

        if ($studentId === 'Unknown' || empty($studentId)) {
            return redirect()->back()->withErrors(['photo' => 'Attendance could not be marked. Student ID unknown.']);
        }

        if (!is_numeric($studentId)) {
            return redirect()->back()->withErrors(['photo' => 'Invalid student ID returned: ' . $studentId]);
        }

        $currentTime = now()->setTimezone('Asia/Kathmandu');
        $startTime = $currentTime->copy()->setTime(14, 0, 0);
        $endTime = $currentTime->copy()->setTime(17, 30, 0);

        $attendanceToday = Attendance::where('student_id', $studentId)
            ->whereDate('created_at', $currentTime->toDateString())
            ->exists();

        if ($attendanceToday) {
            return redirect()->back()->withErrors(['photo' => 'Attendance has already been marked for today.']);
        }

        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            $classId = $this->getClassIdForStudent($studentId);
            if (!$classId) {
                return redirect()->back()->withErrors(['photo' => 'Class not found for student ID: ' . $studentId]);
            }

            Attendance::create([
                'student_id' => $studentId,
                'class_id' => $classId,
                'status' => 'present',
            ]);

            return back()->with('status', 'Attendance marked as present.');
        } else {
            return back()->with('status', 'Attendance can only be marked between 2 PM and 5 PM.');
        }
    }

    private function getClassIdForStudent($studentId)
    {
        $user = User::find($studentId);
        return $user ? $user->class_id : null;
    }

    public function viewAttendance()
    {
        $student = Auth::user();
        $currentTime = now()->setTimezone('Asia/Kathmandu');
        $attendances = Attendance::where('student_id', $student->id)->with('student')->get();

        return view('student.attendance.list', compact('attendances'));
    }

    public function addAttendance()
    {
        return view('student.attendance.add');
    }


    public function listClasses()
    {
        $classes = ClassModel::all();
        return view('admin.attendance.classes', compact('classes'));
    }


    public function showAttendanceByClass(ClassModel $class, Request $request)
    {
        $date = $request->input('date', now()->toDateString()); 

        $attendances = Attendance::with('student')
            ->whereHas('student', function ($query) use ($class) {
                $query->where('class_id', $class->id);
            })
            ->whereDate('created_at', $date) 
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $students = User::where('class_id', $class->id)->get();

        return view('admin.attendance.class-attendance', compact('class', 'attendances', 'students', 'date'));
    }
    public function showAttendanceByStudent(ClassModel $class, User $student)
    {
        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.attendance.student-attendance', compact('class', 'student', 'attendances'));
    }
}

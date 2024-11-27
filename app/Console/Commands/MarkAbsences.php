<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkAbsences extends Command
{
    protected $signature = 'app:mark-absences';
    protected $description = 'Mark absences for students who are not present';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Only mark absences if the current time is after 6 PM
        if (Carbon::now()->setTimezone('Asia/Kathmandu')->hour < 17) {
            $this->info('Absences can only be marked after 6 PM.');
            return;
        }

        // Assuming 'is_role' 3 represents students
        $students = User::where('is_role', 3)->get();

        foreach ($students as $student) {
            // Check if the student was present
            $present = Attendance::where('student_id', $student->id)
                ->whereDate('created_at', Carbon::now()->setTimezone('Asia/Kathmandu')->today())
                ->exists();

            if (!$present) {
                // Mark the student as absent
                Attendance::create([
                    'student_id' => $student->id,
                    'class_id' => $student->class_id, // Ensure class_id is available
                    'status' => 'absent',
                ]);
            }
        }

        $this->info('Absences marked successfully.');
    }
}

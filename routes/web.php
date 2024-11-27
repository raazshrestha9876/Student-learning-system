<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentSubmissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'AuthLogout']);



Route::group(['middleware' => 'admin'], function () {
    //dashboard
    Route::get('admin/dashboard', [DashboardController::class, 'Dashboard']);

    //Admin
    Route::get('admin/admin/list', [AdminController::class, 'List']);
    Route::get('admin/admin/add', [AdminController::class, 'Add']);
    Route::post('admin/admin/create', [AdminController::class, 'Create']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'Edit']);
    Route::post('admin/admin/update/{id}', [AdminController::class, 'Update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'Delete']);

    //class
    Route::get('admin/class/list', [ClassController::class, 'List']);
    Route::get('admin/class/add', [ClassController::class, 'Add']);
    Route::post('admin/class/create', [ClassController::class, 'Create']);
    Route::get('admin/class/edit/{id}', [ClassController::class, 'Edit']);
    Route::post('admin/class/update/{id}', [ClassController::class, 'Update']);
    Route::get('admin/class/delete/{id}', [ClassController::class, 'Delete']);

    //subject
    Route::get('admin/subject/list', [SubjectController::class, 'List']);
    Route::get('admin/subject/add', [SubjectController::class, 'Add']);
    Route::post('admin/subject/create', [SubjectController::class, 'Create']);
    Route::get('admin/subject/edit/{id}', [SubjectController::class, 'Edit']);
    Route::post('admin/subject/update/{id}', [SubjectController::class, 'Update']);
    Route::get('admin/subject/delete/{id}', [SubjectController::class, 'Delete']);

    //assign_subject
    Route::get('admin/class_subject/list', [ClassSubjectController::class, 'List']);
    Route::get('admin/class_subject/add', [ClassSubjectController::class, 'Add']);
    Route::post('admin/class_subject/create', [ClassSubjectController::class, 'Create']);
    Route::get('admin/class_subject/edit/{id}', [ClassSubjectController::class, 'Edit']);
    Route::post('admin/class_subject/update/{id}', [ClassSubjectController::class, 'Update']);
    Route::get('admin/class_subject/delete/{id}', [ClassSubjectController::class, 'Delete']);

    //student
    Route::get('admin/student/list', [StudentController::class, 'List']);
    Route::get('admin/student/add', [StudentController::class, 'Add']);
    Route::post('admin/student/create', [StudentController::class, 'Create']);
    Route::get('admin/student/edit/{id}', [StudentController::class, 'Edit']);
    Route::post('admin/student/update/{id}', [StudentController::class, 'Update']);
    Route::get('admin/student/delete/{id}', [StudentController::class, 'Delete']);

    //teacher
    Route::get('admin/teacher/list', [TeacherController::class, 'List']);
    Route::get('admin/teacher/add', [TeacherController::class, 'Add']);
    Route::post('admin/teacher/create', [TeacherController::class, 'Create']);
    Route::get('admin/teacher/edit/{id}', [TeacherController::class, 'Edit']);
    Route::post('admin/teacher/update/{id}', [TeacherController::class, 'Update']);
    Route::get('admin/teacher/delete/{id}', [TeacherController::class, 'Delete']);

    //assign class to teacher
    Route::get('admin/teacher_class/list', [TeacherClassController::class, 'List']);
    Route::get('admin/teacher_class/add', [TeacherClassController::class, 'Add']);
    Route::post('admin/teacher_class/create', [TeacherClassController::class, 'Create']);
    Route::get('admin/teacher_class/get_subjects/{classId}', [TeacherClassController::class, 'getSubjects']);
    Route::get('admin/teacher_class/delete/{id}', [TeacherClassController::class, 'Delete']);

    // web.php
    Route::get('admin/attendance/classes', [AttendanceController::class, 'listClasses']);
    Route::get('admin/attendance/classes/{class}/attendance', [AttendanceController::class, 'showAttendanceByClass']);
    Route::get('admin/classes/{class}/attendance/student/{student}', [AttendanceController::class, 'showAttendanceByStudent']);
});

Route::group(['middleware' => 'teacher'], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'Dashboard']);
    Route::get('teacher/profile', [TeacherController::class, 'profileShow']);
    Route::get('teacher/timeline', [TeacherClassController::class, 'timeline']);

    //assignment
    Route::get('teacher/assignment/list', [AssignmentController::class, 'List']);
    Route::get('teacher/assignment/add', [AssignmentController::class, 'Add']);
    Route::post('teacher/assignment/create', [AssignmentController::class, 'Create']);
    Route::get('teacher/assignment/get-subjects/{classId}', [AssignmentController::class, 'getSubjects']);
    Route::get('teacher/assignment/delete/{id}', [AssignmentController::class, 'Delete']);
    Route::get('teacher/assignment/{assignmentId}/submissions', [AssignmentSubmissionController::class, 'viewSubmissions']);

    Route::get('teacher/quiz/index', [QuizController::class, 'index']);
    Route::get('quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('quizzes/store', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{id}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('quizzes/{quiz}/scores', [QuizController::class, 'showStudentsScores'])->name('quizzes.scores');
});

Route::group(['middleware' => 'student'], function () {
    Route::get('student/dashboard', [DashboardController::class, 'Dashboard']);
    Route::get('student/profile', [StudentController::class, 'profileShow']);

    Route::get('student/assignment', [StudentController::class, 'assignment']);
    Route::get('student/assignment/submission/add/{assignmentId}', [AssignmentSubmissionController::class, 'submissionForm']);
    Route::post('student/assignment/submission/create/{assignmentId}', [AssignmentSubmissionController::class, 'storeSubmission']);

    Route::get('student/attendance/view', [AttendanceController::class, 'viewAttendance']);
    Route::get('student/attendance/add', [AttendanceController::class, 'addAttendance']);
    Route::post('student/attendance/create', [AttendanceController::class, 'createAttendance']);

    Route::get('student/quiz/index', [QuizController::class, 'studentIndex']);
    Route::get('quizzes/{quiz}/take', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
});


Route::middleware('auth')->group(function () {
    Route::get('chat', [ChatController::class, 'index']);
    Route::get('chat/{userId}', [ChatController::class, 'showChat']);
    Route::post('chat/send', [ChatController::class, 'send']);
    Route::get('chat/get-students/{id}', [ChatController::class, 'getStudents']);
});

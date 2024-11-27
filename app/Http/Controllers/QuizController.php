<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\ClassModel;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('teacher.quiz.index', compact('quizzes'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        return view('teacher.quiz.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.text' => 'required|string',
            'questions.*.answers.*.is_correct' => 'boolean',
        ]);

        $quiz = Quiz::create([
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        foreach ($request->questions as $questionData) {
            $question = $quiz->questions()->create([
                'question_text' => $questionData['text'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $question->answers()->create([
                    'answer_text' => $answerData['text'],
                    'is_correct' => isset($answerData['is_correct']) ? true : false,
                ]);
            }
        }

        return redirect()->route('teacher/quiz/index')->with('success', 'Quiz created successfully.');
    }


    public function show($id)
    {
        $quiz = Quiz::with('questions.answers')->find($id);
        return view('teacher.quiz.show', compact('quiz'));
    }

    public function studentIndex()
    {

        $studentClassId = Auth::user()->class_id;
        $quizzes = Quiz::where('class_id', $studentClassId)->get();

        return view('student.quiz.index', compact('quizzes'));
    }
    public function take(Quiz $quiz)
    {
        $studentClassId = Auth::user()->class_id;

        if ($quiz->class_id !== $studentClassId) {
            return redirect()->route('student.quiz.index')->with('error', 'You are not authorized to take this quiz.');
        }
        return view('student.quiz.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $score = 0;

        $request->validate([
            'answers' => 'required|array',
        ]);

        foreach ($request->answers as $questionId => $answerId) {
            $answer = Answer::find($answerId);
            if ($answer && $answer->is_correct) {
                $score++;
            }
        }

        QuizResult::updateOrCreate(
            [
                'student_id' => Auth::id(), 
                'quiz_id' => $quiz->id,
            ],
            ['marks' => $score] 
        );

        return view('student.quiz.result', compact('score'));
    }



    public function showStudentsScores($quizId)
    {
        $quiz = Quiz::with('quizResults.student')->find($quizId);
        $students = User::with('quizResults')
            ->where('class_id', $quiz->class_id)
            ->get();

        $winner = null;
        $highestScore = 0;

        foreach ($students as $student) {
            $score = $student->quizResults()->where('quiz_id', $quiz->id)->first();
            if ($score && $score->marks > $highestScore) {
                $highestScore = $score->marks;
                $winner = $student;
            }
        }

        return view('teacher.quiz.result', compact('quiz', 'students', 'winner', 'highestScore'));
    }
}

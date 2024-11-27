{{-- resources/views/quizzes/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1 class="mb-4">Quiz: {{ $quiz->title }}</h1>
        <a href="{{ url('teacher/quiz/index') }}" class="btn btn-secondary mb-3">Back to Quizzes</a>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title">Quiz Details</h3>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Description</h5>
                    <p class="text-muted">{{ $quiz->description }}</p>

                    <h5 class="mt-4">Questions</h5>
                    @foreach($quiz->questions as $question)
                        <div class="mb-4 p-3 border rounded bg-light">
                            <h6 class="font-weight-bold">Question: {{ $question->question_text }}</h6>
                            <h6>Answers:</h6>
                            <ul class="list-unstyled">
                                @foreach($question->answers as $answer)
                                    <li class="d-flex justify-content-between align-items-center mb-2">
                                        <span>
                                            {{ $answer->answer_text }} 
                                            @if($answer->is_correct)
                                                <span class="text-success">(Correct)</span>
                                            @endif
                                        </span>
                                        <button class="btn btn-info btn-sm" onclick="alert('You selected: {{ $answer->answer_text }}')">Select</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .card {
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .border {
        border: 1px solid #dee2e6;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .btn-info {
        margin-left: 10px;
    }
</style>
@endsection

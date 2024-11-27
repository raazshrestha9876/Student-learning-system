
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Your Quizzes</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title">Available Quizzes</h3>
                </div>
                <div class="card-body">
                    @if($quizzes->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            No quizzes available at the moment.
                        </div>
                    @else
                        <ul class="list-group">
                            @foreach ($quizzes as $quiz)
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 mb-4 shadow-sm">
                                    <div class="flex-grow-1">
                                        <strong class="d-block mb-1 quiz-title">{{ $quiz->title }}</strong>
                                        <small class="text-muted quiz-description">{{ $quiz->description }}</small><br>
                                        <small class="text-muted quiz-date">Created on: {{ $quiz->created_at->format('d M Y') }}</small>
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('quizzes.take', $quiz) }}" class="btn btn-primary btn-lg">Take Quiz</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .content-header h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        font-weight: bold;
        text-align: center;
        color: #343a40;
    }

    .list-group-item {
        padding: 20px;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        background-color: #f8f9fa;
    }

    .list-group-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .quiz-title {
        font-size: 1.5rem;
        color: #007bff;
    }

    .quiz-description {
        font-size: 1.1rem;
    }

    .quiz-date {
        font-size: 0.9rem;
    }

    .btn-primary {
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .alert {
        font-weight: 600;
        font-size: 1.1rem;
        text-align: center;
    }
</style>

@endsection

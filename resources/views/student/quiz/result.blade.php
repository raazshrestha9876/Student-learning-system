@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1 class="text-center">Quiz Result</h1>
    </section>

    <section class="content">
        <div class="container-fluid text-center">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Your Score</h4>
                </div>
                <div class="card-body">
                    <h3 class="display-4">{{ $score }}</h3>
                    <p class="lead">Thank you for participating!</p>
                    <a href="{{ url('student/quiz/index')}}" class="btn btn-primary btn-lg">Back to Quizzes</a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .content-header h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #343a40;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    .display-4 {
        font-size: 3rem;
        font-weight: bold;
        color: #28a745;
    }

    .lead {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .btn-primary {
        padding: 12px 24px;
        font-size: 1.2rem;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

@endsection

@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1 class="text-center">Take Quiz: <span class="text-primary">{{ $quiz->title }}</span></h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
                @csrf
                @foreach ($quiz->questions as $question)
                    <div class="form-group mb-4">
                        <label class="h5">{{ $question->question_text }}</label>
                        @foreach ($question->answers as $answer)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required>
                                <label class="form-check-label">{{ $answer->answer_text }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit" class="btn btn-success btn-lg">Submit</button>
            </form>
        </div>
    </section>
</div>

<style>
    .content-header h1 {
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #343a40;
    }

    .form-group {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        background-color: #f9f9f9;
        transition: box-shadow 0.3s;
    }

    .form-group:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-check {
        margin-bottom: 10px;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .btn-success {
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>

@endsection

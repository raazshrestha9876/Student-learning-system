{{-- resources/views/quizzes/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Quiz</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('quizzes.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-4">
                    <label for="class_id">Select Class</label>
                    <select name="class_id" class="form-control" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="title">Quiz Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div id="questions-container" class="mb-4">
                    <div class="question border p-4 rounded mb-3">
                        <h5>Question</h5>
                        <input type="text" name="questions[0][text]" class="form-control mb-3" required>
                        <h6>Answers</h6>
                        <div class="answer-options">
                            @for($i = 0; $i < 4; $i++)
                            <div class="input-group mb-2">
                                <input type="text" name="questions[0][answers][{{ $i }}][text]" class="form-control" placeholder="Answer {{ $i + 1 }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="checkbox" name="questions[0][answers][{{ $i }}][is_correct]" value="1"> Correct
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <button type="button" id="add-question" class="btn btn-primary">Add Question</button>
                <button type="submit" class="btn btn-success">Create Quiz</button>
            </form>
        </div>
    </section>
</div>

<script>
document.getElementById('add-question').addEventListener('click', function() {
    const container = document.getElementById('questions-container');
    const questionCount = container.getElementsByClassName('question').length;
    const questionDiv = document.createElement('div');
    questionDiv.classList.add('question', 'border', 'p-4', 'rounded', 'mb-3');
    questionDiv.innerHTML = `
        <h5>Question</h5>
        <input type="text" name="questions[${questionCount}][text]" class="form-control mb-3" required>
        <h6>Answers</h6>
        <div class="answer-options">
            ${Array.from({length: 4}, (_, i) => `
                <div class="input-group mb-2">
                    <input type="text" name="questions[${questionCount}][answers][${i}][text]" class="form-control" placeholder="Answer ${i + 1}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" name="questions[${questionCount}][answers][${i}][is_correct]" value="1"> Correct
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
    container.appendChild(questionDiv);
});
</script>

<style>
    .question {
        transition: box-shadow 0.3s ease;
    }

    .question:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .input-group {
        margin-bottom: 15px;
    }

    .btn-primary,
    .btn-success {
        width: 20%;
        padding: 15px;
        font-size: 16px;
    }

    .btn-primary {
        margin-top: 10px;
    }

    .btn-success {
        margin-top: 10px;
    }
</style>
@endsection

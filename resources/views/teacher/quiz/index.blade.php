{{-- resources/views/quizzes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Quizzes</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Create New Quiz</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">Quiz List</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Quiz Title</th>
                                        <th>Description</th>
                                        <th>Class</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quizzes as $key => $quiz)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $quiz->title }}</td>
                                        <td>{{ $quiz->description }}</td>
                                        <td>{{ $quiz->class->name ?? 'N/A' }}</td>
                                        <td>{{ $quiz->created_at->format('d-m-Y H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('quizzes.scores', $quiz->id) }}" class="btn btn-success btn-sm">Result</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

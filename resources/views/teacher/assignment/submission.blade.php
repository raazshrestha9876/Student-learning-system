@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Assignment Submissions</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">List of Submissions for {{ $assignment->teacherClass->subject->name }}</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Roll Number</th>
                                        <th>Class</th>
                                        <th>Submission Date</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignment->submissions as $key => $submission)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $submission->student->name }}</td>
                                        <td>{{ $submission->student->roll_no }}</td>
                                        <td>{{ $assignment->teacherClass->classesAsTeacher->name }}</td>
                                        <td>{{ $submission->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ asset('upload/documents/' . $submission->submission_file) }}" class="btn btn-success">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <!-- Optional footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

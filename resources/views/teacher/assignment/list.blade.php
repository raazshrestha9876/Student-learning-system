@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Assignment Records</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ url('teacher/assignment/add') }}" class="btn btn-primary">Add Assignment</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">Assignment Records</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Class Name</th>
                                        <th>Subject</th>
                                        <th>Submission Date</th>
                                        <th>Description</th>
                                        <th>Document</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $key => $assignment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $assignment->teacherClass->classesAsTeacher->name }}</td>
                                            <td>{{ $assignment->teacherClass->subject->name }}</td>
                                            <td>{{ $assignment->submission_date }}</td>
                                            <td>{{ $assignment->description }}</td>
                                            <td>
                                                <a href="{{ asset('upload/documents/' . $assignment->document) }}" target="_blank">View Document</a>
                                            </td>
                                            <td>
                                                <a href="{{ url('teacher/assignment/edit', $assignment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ url('teacher/assignment/delete', $assignment->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                                
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

@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Assignments List</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">List of Assignments</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Assignment Date</th>
                                        <th>Submission Date</th>
                                        <th>Description</th>
                                        <th>Document</th>
                                        <th>Actions</th> <!-- Add action column for submission -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $key => $assignment) <!-- Loop through assignments -->
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $assignment->teacherClass->subject->name }}</td>
                                        <td>{{ $assignment->created_at }}</td>
                                        <td>{{ $assignment->submission_date }}</td>
                                        <td>{{ $assignment->description }}</td>
                                        <td>
                                            @if ($assignment->document)
                                            <a href="{{ asset('upload/documents/' . $assignment->document) }}" download class="btn btn-success">
                                                Download
                                            </a>
                                            @else
                                            <span>No document uploaded</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('student/assignment/submission/add/' . $assignment->id) }}">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-upload"></i> Submit Assignment
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach <!-- End of assignment loop -->
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <!-- Additional Footer Content (Optional) -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

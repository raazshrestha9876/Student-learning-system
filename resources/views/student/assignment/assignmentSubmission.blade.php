@extends('layouts.app')

@section('content')
<div class="content-wrapper mt-2">

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header bg-dark text-white text-center">
                            <h3>Assignment Submission</h3>
                        </div>

                        <div class="card-body">
                            <form action="{{ url('student/assignment/submission/create/' . $assignment->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Assignment Details -->
                                <div class="form-group">
                                    <label for="assignment" class="font-weight-bold">Subject</label>
                                    <p class="bg-light p-2 border rounded">{{ $assignment->teacherClass->subject->name }}</p>
                                </div>

                                <div class="form-group">
                                    <label for="assignment" class="font-weight-bold">Description</label>
                                    <p class="bg-light p-2 border rounded">{{ $assignment->description }}</p>
                                </div>
                                <!-- File Upload -->
                                <div class="form-group">
                                    <label for="submission_file" class="font-weight-bold">Upload Your Assignment</label>
                                    <input type="file" name="submission_file" class="form-control-file border p-2" required>
                                    <small class="form-text text-muted">Accepted formats: pdf, doc, docx (Max: 2MB)</small>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-lg shadow">
                                        <i class="fas fa-upload"></i> Submit Assignment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

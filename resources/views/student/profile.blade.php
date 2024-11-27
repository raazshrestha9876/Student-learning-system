@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card shadow-lg rounded">
                        <div class="card-header bg-success text-white text-center">
                            <h3 class="card-title">Student Profile</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('upload/images/' . $student->profile_pic) }}" alt="{{ $student->name }}" class="img-fluid rounded-circle border border-success" style="width: 150px; height: 150px;">
                                    <h4 class="mt-3">{{ $student->name }}</h4>
                                    <p class="text-muted">{{ $student->email }}</p>
                                    <p class="text-success"><strong>Status: {{ $student->status == 0 ? 'Active' : 'Inactive' }}</strong></p>
                                </div>
                                <div class="col-md-8">
                                    <h2 class="mt-3 ml-3">Profile Information</h2>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Roll No:</strong> {{ $student->roll_no }}</li>
                                        <li class="list-group-item"><strong>Date of Birth:</strong> {{ $student->dob }}</li>
                                        <li class="list-group-item"><strong>Phone Number:</strong> {{ $student->phone_no }}</li>
                                        <li class="list-group-item"><strong>Admission No:</strong> {{ $student->admission_no }}</li>
                                        <li class="list-group-item"><strong>Admission Date:</strong> {{ $student->admission_date }}</li>
                                        <li class="list-group-item"><strong>Address:</strong> {{ $student->address }}</li>
                                        <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($student->gender) }}</li>
                                        <li class="list-group-item"><strong>Class:</strong> {{ $student->classAsStudent->name }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.3s;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .list-group-item {
        border: none;
        padding: 15px;
        background-color: #f0f8ff;
        transition: background-color 0.3s;
    }
    .list-group-item:hover {
        background-color: #e0f7fa;
    }
    .text-muted {
        font-size: 0.9em;
    }
    .btn-warning {
        background-color: #ffc107;
        border: none;
    }
    .btn-warning:hover {
        background-color: #ffca2c;
    }
</style>
@endpush

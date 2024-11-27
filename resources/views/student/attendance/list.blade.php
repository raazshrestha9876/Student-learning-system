@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Attendance Records</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ url('student/attendance/add') }}" class="btn btn-primary">Add Attendance</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">Attendance Records</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Student ID</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $key => $attendance)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $attendance->student->name }}</td>
                                            <td>{{ $attendance->student->id }}</td>
                                            <td>{{ $attendance->status === 'present' ? 'Present' : 'Absent' }}</td>
                                            <td>{{ $attendance->created_at->format('d-m-Y H:i:s') }}</td>
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

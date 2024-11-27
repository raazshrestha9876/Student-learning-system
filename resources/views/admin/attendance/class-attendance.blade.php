@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Attendance Records for Class: {{ $class->name }}</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar with student list -->
                <aside class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4 class="card-title">Students</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($students as $student)
                                    <li class="list-group-item">
                                        <a href="{{ url('admin/classes/' . $class->id . '/attendance/student/' . $student->id) }}">
                                            {{ $student->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>

                <!-- Main content for attendance records -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">Attendance Records for Date: {{ $date }}</h3>
                        </div>

                        <!-- Filter by date form -->
                        <div class="card-body">
                            <form action="{{ url('admin/attendance/classes/' . $class->id . '/attendance') }}" method="GET">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-2 col-form-label">Filter by Date</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="date" class="form-control" value="{{ $date }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Attendance table -->
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
                            {{ $attendances->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

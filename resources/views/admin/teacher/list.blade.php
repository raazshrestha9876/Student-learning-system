@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('admin/teacher/add') }}">
                        <button class="btn btn-primary btn-lg" style="font-size: 18px; padding: 12px 24px;">Add New Teacher</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title" style="font-size: 24px;">View Teachers</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>S.N</th>
                                            <th>Profile</th>
                                            <th>Name</th>
                                            <th>DOB</th>
                                            <th>Phone No</th>
                                            <th>Address</th>
                                            <th>Appointment Date</th>
                                            <th>Qualification</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teachers as $teacher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset('upload/images/' . $teacher->profile_pic) }}" alt="{{ $teacher->name }}" style="width: 50px; height: 50px; border-radius: 50%; box-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                                            </td>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->dob }}</td>
                                            <td>{{ $teacher->phone_no }}</td>
                                            <td>{{ $teacher->address }}</td>
                                            <td>{{ $teacher->appointment_date }}</td>
                                            <td>{{ $teacher->qualification }}</td>
                                            <td>{{ $teacher->email }}</td>
                                            <td>{{ $teacher->gender }}</td>
                                            <td>{{ $teacher->status == 0 ? '🟢 Active' : '🔴 Inactive' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ url('admin/teacher/edit/'.$teacher->id) }}">
                                                        <button class="btn btn-warning btn-sm mr-2">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/teacher/delete/'.$teacher->id) }}">
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix" style="background-color: white;">
                            {{ $teachers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

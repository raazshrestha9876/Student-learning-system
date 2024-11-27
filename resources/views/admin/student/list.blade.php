@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-3">
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('admin/student/add') }}">
                        <button class="btn btn-primary btn-lg" style="font-size: 18px; padding: 12px 24px;">
                            Add New Student
                        </button>
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
                            <h3 class="card-title" style="font-size: 24px;">View Students</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 50px; font-size: 20px;">S.N</th>
                                        <th style="font-size: 20px;">Profile</th>
                                        <th style="font-size: 20px;">Name</th>
                                        <th style="font-size: 20px;">Roll No</th>
                                        <th style="font-size: 20px;">DOB</th>
                                        <th style="font-size: 20px;">Class</th>
                                        <th style="font-size: 20px;">Phone No</th>
                                        <th style="font-size: 20px;">Admission No</th>
                                        <th style="font-size: 20px;">Admission Date</th>
                                        <th style="font-size: 20px;">Gender</th>
                                        <th style="font-size: 20px;">Address</th>
                                        <th style="font-size: 20px;">Status</th>
                                        <th style="font-size: 20px;">Email</th>
                                        <th style="width: 150px; font-size: 20px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td style="font-size: 18px;">{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('upload/images/' . $student->profile_pic) }}" alt="{{ $student->name }}" style="width: 50px; height: 50px; border-radius: 50%; box-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                                        </td>
                                        <td style="font-size: 18px;">{{ $student->name }}</td>
                                        <td style="font-size: 18px;">{{ $student->roll_no }}</td>
                                        <td style="font-size: 18px;">{{ $student->dob }}</td>
                                        <td style="font-size: 18px;">{{ $student->classAsStudent->name }}</td>
                                        <td style="font-size: 18px;">{{ $student->phone_no }}</td>
                                        <td style="font-size: 18px;">{{ $student->admission_no }}</td>
                                        <td style="font-size: 18px;">{{ $student->admission_date }}</td>
                                        <td style="font-size: 18px;">{{ $student->gender }}</td>
                                        <td style="font-size: 18px;">{{ $student->address }}</td>
                                        <td style="font-size: 18px;">{{ $student->status == 0 ? '🟢 Active' : '🔴 Inactive' }}</td>
                                        <td style="font-size: 18px;">{{ $student->email }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ url('admin/student/edit/'.$student->id) }}">
                                                    <button class="btn btn-warning btn-sm" style="font-size: 16px; padding: 6px 12px;">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                <a href="{{ url('admin/student/delete/'.$student->id) }}">
                                                    <button class="btn btn-danger btn-sm" style="font-size: 16px; padding: 6px 12px;">
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
                        <div class="card-footer" style="margin-left:auto; background-color:white">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

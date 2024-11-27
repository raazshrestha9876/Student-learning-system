@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('admin/admin/add') }}">
                        <button class="btn btn-primary btn-lg shadow-lg">Add New Admin</button>
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
                            <h3 class="card-title">View Admins</h3>
                        </div>
                        <div class="card-body table-responsive p-4">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr style="font-size: 18px;">
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $admin)
                                    <tr style="font-size: 16px;">
                                        <td>{{ $admin->id }}</td>
                                        <td>
                                            <img src="{{ asset('upload/images/'.$admin->profile_pic) }}" alt="{{ $admin->name }}" style="width: 50px; height: 50px; border-radius: 50%; box-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->dob }}</td>
                                        <td>{{ $admin->gender }}</td>
                                        <td>{{ $admin->address }}</td>
                                        <td>{{ $admin->status == 0 ? 'Active 🟢' : 'Inactive 🔴' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <a href="{{ url('admin/admin/edit/'.$admin->id) }}" class="btn btn-warning btn-sm mr-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ url('admin/admin/delete/'.$admin->id) }}" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

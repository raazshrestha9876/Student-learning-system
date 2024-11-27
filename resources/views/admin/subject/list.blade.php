@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-3">
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('admin/subject/add') }}">
                        <button class="btn btn-primary btn-lg" style="font-size: 18px; padding: 12px 24px;">Add Subject</button>
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
                            <h3 class="card-title" style="font-size: 24px;">View Subjects</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 50px; font-size: 20px;">S.N</th>
                                        <th style="font-size: 20px;">Subject Name</th>
                                        <th style="font-size: 20px;">Type</th>
                                        <th style="font-size: 20px;">Credit Hour</th>
                                        <th style="font-size: 20px;">Status</th>
                                        <th style="width: 150px; font-size: 20px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $subject)
                                    <tr>
                                        <td style="font-size: 18px;">{{ $loop->iteration }}</td>
                                        <td style="font-size: 18px;">{{ $subject->name }}</td>
                                        <td style="font-size: 18px;">{{ $subject->type }}</td>
                                        <td style="font-size: 18px;">{{ $subject->credit_hour }}</td>
                                        <td style="font-size: 18px;">{{ $subject->status == 0 ? '🟢 Active' : '🔴 Inactive' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ url('admin/subject/edit/'.$subject->id) }}">
                                                    <button class="btn btn-warning btn-sm mr-2">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                <a href="{{ url('admin/subject/delete/'.$subject->id) }}">
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
                        <div class="card-footer clearfix">
                            {{ $subjects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

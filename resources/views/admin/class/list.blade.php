@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-3">
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('admin/class/add') }}">
                        <button class="btn btn-primary btn-lg" style="font-size: 18px; padding: 12px 24px;">
                            Add Class
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
                            <h3 class="card-title" style="font-size: 24px; margin-bottom: 0;">
                                <i class="fas fa-chalkboard"></i> View Classes
                            </h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 50px; font-size: 20px;">S.N</th>
                                        <th style="font-size: 20px;">Class Name</th>
                                        <th style="font-size: 20px;">Status</th>
                                        <th style="width: 200px; font-size: 20px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classes as $class)
                                    <tr>
                                        <td style="font-size: 18px;">{{ $loop->iteration }}</td>
                                        <td style="font-size: 18px;">{{ $class->name }}</td>
                                        <td style="font-size: 18px;">
                                            {{ ($class->status == 0) ? '🟢 Active' : '🔴 Inactive' }}
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/class/edit/'.$class->id) }}" class="btn btn-warning btn-sm" style="font-size: 16px; padding: 6px 12px;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ url('admin/class/delete/'.$class->id) }}" class="btn btn-danger btn-sm" style="font-size: 16px; padding: 6px 12px;">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <nav aria-label="Page navigation">
                                {{ $classes->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

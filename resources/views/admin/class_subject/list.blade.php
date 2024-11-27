@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @include('_message')
            <div class="row mb-4">
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('admin/class_subject/add') }}">
                        <button class="btn btn-primary btn-lg shadow-lg">Assign Class Subject</button>
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
                            <h3 class="card-title" style="font-size: 24px;">
                                <i class="fas fa-book"></i> View Class Subjects
                            </h3>
                        </div>
                        <div class="card-body table-responsive p-4">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr style="font-size: 18px;">
                                        <th style="width: 60px;">S.N</th>
                                        <th>Class Name</th>
                                        <th>Subjects</th>
                                        <th style="width: 200px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = 1;
                                    @endphp
                                    @for($i = 0; $i < count($class_subjects); $i++)
                                        @php
                                            $class = $class_subjects[$i]->classes;
                                            $subjects = [];
                                            while($i < count($class_subjects) && $class_subjects[$i]->class_id == $class->id) {
                                                $subjects[] = $class_subjects[$i]->subjects;
                                                $i++;
                                            }
                                            $i--;
                                        @endphp
                                        <tr style="font-size: 18px;">
                                            <td>{{ $serial++ }}</td>
                                            <td>{{ $class->name }}</td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    @foreach($subjects as $subject)
                                                        <li style="margin-bottom: 10px;">
                                                            <i class="fas fa-check-circle text-success"></i> 
                                                            <strong style="font-size: 16px;">{{ $subject->name }}</strong>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/class_subject/edit/'.$class->id) }}" class="btn btn-warning shadow-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ url('admin/class_subject/delete/'.$class->id) }}" class="btn btn-danger shadow-sm">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <nav aria-label="Page navigation">
                                {{ $class_subjects->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      @include('_message')
      <div class="row mb-2">
        <div class="col-sm-12 d-flex justify-content-end">
          <a href="{{ url('admin/teacher_class/add') }}">
            <button class="btn btn-primary"><i class="fas fa-plus"></i> Assign Teacher Class</button>
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
              <h3 class="card-title">View Teacher Class</h3>
            </div>
            <div class="card-body p-3">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th style="font-size: 1.1rem;">S.N</th>
                      <th style="font-size: 1.1rem;">Teacher Name</th>
                      <th style="font-size: 1.1rem;">Classes</th>
                      <th style="font-size: 1.1rem;">Subjects</th>
                      <th style="font-size: 1.1rem;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $groupedClasses = $teacher_classes->groupBy('teacher_id');
                    @endphp
                    @foreach($groupedClasses as $teacherId => $classes)
                      @php
                        $firstClass = $classes->first();
                        $teacherName = $firstClass->teachers->name;
                        $subjectGroups = $classes->groupBy('class_id');
                      @endphp
                      @foreach($subjectGroups as $classId => $groupedSubjects)
                        <tr>
                          @if ($loop->first) <!-- Only show teacher name and S.N for the first entry -->
                            <td rowspan="{{ $subjectGroups->count() }}" style="font-size: 1.1rem;">{{ $loop->parent->iteration }}</td>
                            <td rowspan="{{ $subjectGroups->count() }}" style="font-size: 1.1rem;">{{ $teacherName }}</td>
                          @endif
                          <td style="font-size: 1.1rem;">{{ $groupedSubjects->first()->classesAsTeacher->name }}</td>
                          <td style="font-size: 1.1rem;">
                            <ul class="list-unstyled">
                              @foreach($groupedSubjects as $subject)
                                <li>
                                  <i class="fas fa-check-circle text-success"></i> {{ $subject->subject->name }}
                                </li>
                              @endforeach
                            </ul>
                          </td>
                          @if ($loop->first) <!-- Only show action buttons for the first entry -->
                            <td rowspan="{{ $subjectGroups->count() }}">
                              <div>
                                <a href="{{ url('admin/teacher_class/edit/'.$firstClass->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <a href="{{ url('admin/teacher_class/delete/'.$firstClass->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                              </div>
                            </td>
                          @endif
                        </tr>
                      @endforeach
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-light">
              {{ $teacher_classes->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
@endsection

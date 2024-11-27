@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">My Timeline</h3>
            </div>
            <div class="card-body p-3">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th>S.N</th>
                      <th>Class Name</th>
                      <th>Subjects</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($teacher_classes->groupBy('class_id') as $classId => $classGroup)
                      @php
                        $firstClass = $classGroup->first();
                      @endphp
                      <tr>
                        <td rowspan="{{ $classGroup->count() }}">{{ $loop->iteration }}</td>
                        <td rowspan="{{ $classGroup->count() }}">{{ $firstClass->classesAsTeacher->name }}</td>
                        <td>
                          <i class="fas fa-check-circle text-success"></i> {{ $firstClass->subject->name }}
                        </td>
                      </tr>
                      @foreach ($classGroup->slice(1) as $subject)
                      <tr>
                        <td>
                          <i class="fas fa-check-circle text-success"></i> {{ $subject->subject->name }}
                        </td>
                      </tr>
                      @endforeach
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-light">
              <!-- Add pagination or any footer content here if needed -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

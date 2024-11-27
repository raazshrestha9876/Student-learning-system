@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Assign Class to Teacher</h3>
                        </div>
                        <form id="teacherClassForm">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="text-danger" id="class-error"></p>
                                    <label>Class Name</label>
                                    <select name="class_id" class="form-control" id="classDropdown">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="subject-error"></p>
                                    <label>Subject</label>
                                    <select name="subject_id" class="form-control" id="subjectDropdown">
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="teacher-error"></p>
                                    @foreach($teachers as $teacher)
                                    <div>
                                        <label>
                                            <input type="checkbox" class="teacher-checkbox" name="teacher_ids[]" value="{{$teacher->id}}">
                                            <span class="fw-normal ml-3">{{$teacher->name}}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    const teacherClassForm = document.getElementById('teacherClassForm');
    const classDropdown = document.getElementById('classDropdown');
    const subjectDropdown = document.getElementById('subjectDropdown');

    classDropdown.addEventListener('change', function() {
        const classId = this.value;
        subjectDropdown.innerHTML = '<option value="">Select Subject</option>'; // Reset options

        if (classId) {
            axios.get(`{{ url('admin/teacher_class/get_subjects') }}/${classId}`)
                .then(response => {
                    response.data.subjects.forEach(subject => {
                        subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching subjects:', error);
                });
        }
    });

    teacherClassForm.addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        axios.post('{{ url("admin/teacher_class/create") }}', formData)
            .then(response => {
                alert(response.data.message);
                window.location.href = '{{ url("admin/teacher_class/list") }}';
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;

                    const classErrorElement = document.getElementById('class-error');
                    const subjectErrorElement = document.getElementById('subject-error');
                    const teacherErrorElement = document.getElementById('teacher-error');

                    classErrorElement.textContent = errors.class_id ? errors.class_id[0] : '';
                    subjectErrorElement.textContent = errors.subject_id ? errors.subject_id[0] : '';
                    teacherErrorElement.textContent = errors.teacher_ids ? errors.teacher_ids[0] : '';

                }
            });
    });
</script>
@endsection
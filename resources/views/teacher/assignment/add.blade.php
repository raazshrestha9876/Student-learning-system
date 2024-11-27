@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Assignment</h3>
                        </div>
                        <form id="assignmentForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="text-danger" id="class-error"></p>
                                    <label>Class Name</label>
                                    <select name="class_id" class="form-control" id="assignmentClassDropdown">
                                        <option value="">Select Class</option>
                                        @php
                                            $uniqueClasses = [];
                                        @endphp
                                        @foreach($teacher_classes as $class)
                                            @if (!in_array($class->class_id, $uniqueClasses))
                                                @php
                                                    $uniqueClasses[] = $class->class_id;
                                                @endphp
                                                <option value="{{ $class->class_id }}">{{ $class->classesAsTeacher->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <p class="text-danger" id="subject-error"></p>
                                    <label>Subject</label>
                                    <select name="subject_id" class="form-control" id="assignmentSubjectDropdown">
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <p class="text-danger" id="submission-date-error"></p>
                                    <label>Submission Date</label>
                                    <input type="date" name="submission_date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <p class="text-danger" id="document-error"></p>
                                    <label>Document</label>
                                    <input type="file" name="document" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <p class="text-danger" id="description-error"></p>
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5" required></textarea>
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
    const assignmentForm = document.getElementById('assignmentForm');
    const classDropdown = document.getElementById('assignmentClassDropdown');
    const subjectDropdown = document.getElementById('assignmentSubjectDropdown');

    classDropdown.addEventListener('change', function() {
        const classId = this.value;
        subjectDropdown.innerHTML = '<option value="">Select Subject</option>'; // Reset options

        if (classId) {
            axios.get(`{{ url('teacher/assignment/get-subjects') }}/${classId}`)
                .then(response => {
                    response.data.subjects.forEach(subject => {
                        subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching subjects:', error);
                    alert('Failed to retrieve subjects. Please try again.');
                });
        }
    });

    assignmentForm.addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        axios.post('{{ url("teacher/assignment/create") }}', formData)
            .then(response => {
                alert(response.data.message);
                window.location.href = '{{ url("teacher/assignment/list") }}';
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;

                    document.getElementById('class-error').textContent = errors.class_id ? errors.class_id[0] : '';
                    document.getElementById('subject-error').textContent = errors.subject_id ? errors.subject_id[0] : '';
                    document.getElementById('submission-date-error').textContent = errors.submission_date ? errors.submission_date[0] : '';
                    document.getElementById('document-error').textContent = errors.document ? errors.document[0] : '';
                    document.getElementById('description-error').textContent = errors.description ? errors.description[0] : '';
                }
            });
    });
</script>
@endsection

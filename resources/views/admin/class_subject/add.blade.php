@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Assign Subjects to Class</h3>
                        </div>

                        <form id="classSubjectForm">
                            {{csrf_field()}}
                            <div class="card-body">
                                <!-- Class Selection -->
                                <div class="form-group">
                                    <label for="class_id">Class Name</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Subject Selection -->
                                <div class="form-group">
                                    <label>Select Subjects</label>
                                    <div class="subject-checkbox-group">
                                        @foreach($subjects as $subject)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input subject-checkbox" name="subject_ids[]" value="{{$subject->id}}" id="subject{{$subject->id}}">
                                            <label class="form-check-label" for="subject{{$subject->id}}">{{$subject->name}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <p class="text-danger mt-2" id="subject-error"></p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Assign</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const classSubjectForm = document.getElementById('classSubjectForm');
        const subject_error = document.getElementById('subject-error');
        const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');

        // Log checked values (for debugging)
        function logCheckedValues() {
            const checkedValues = [];
            subjectCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedValues.push(checkbox.value);
                }
            });
            console.log('Checked Values:', checkedValues);
        }

        // Add change event to all checkboxes
        subjectCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', logCheckedValues);
        });

        // Handle form submission
        classSubjectForm.addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            axios.post('{{url("admin/class_subject/create")}}', formData)
                .then((response) => {
                    console.log(response.data);
                    window.location.href = '{{url("admin/class_subject/list")}}';
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        subject_error.textContent = errors.subject_ids ? errors.subject_ids[0] : '';
                    }
                });
        });
    });
</script>
@endsection

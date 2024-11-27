@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Subject</h3>
                        </div>

                        <form id="classSubjectForm">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Class Name</label>
                                    <select name="class_id" class="form-control">
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="subject-error"></p>
                                    @foreach($subjects as $subject)
                                    <div>
                                        <label>
                                            <input type="checkbox" class="subject-checkbox" name="subject_ids[]" value="{{$subject->id}}"><span class="fw-normal ml-3">{{$subject->name}}</span>
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
    const classSubjectForm = document.getElementById('classSubjectForm');
    const subject_error = document.getElementById('subject-error');
    const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');

    function logCheckedValues() {
        const checkedValues = [];
        subjectCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkedValues.push(checkbox.value);
            }
        });
        console.log('Checked Values:', checkedValues);
    }

    subjectCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', logCheckedValues);
    });

    classSubjectForm.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        axios.post('{{url("admin/class_subject/update/".$class_subject->id)}}', formData)
            .then((response) => {
                console.log(response.data);
                window.location.href = '{{url("admin/class_subject/list")}}';
            }).catch((error) => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    subject_error.textContent = errors.subject_ids ? errors.subject_ids[0] : '';
                }
            })
    });
</script>
@endsection
@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Subject</h3>
                        </div>

                        <form id="subjectForm">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="text-danger" id="name-error"></p>
                                    <label>Subject Name</label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Subject Name">
                                </div>
                                <div class="form-group">
                                    <label>Subject Type</label>
                                    <select name="type" class="form-control">
                                        <option value="theory">Theory</option>
                                        <option value="pratical">Pratical</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="credit-hour"></p>
                                    <label>Credit Hour</label>
                                    <input type="text" class="form-control" name="credit_hour" value="{{old('credit_hour')}}" placeholder="Enter Credit Hour">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0">Active</option>
                                        <option value="1">In Active</option>
                                    </select>
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
    const subjectForm = document.getElementById('subjectForm');
    const name_error = document.getElementById('name-error');
    const credit_hour = document.getElementById('credit-hour');

    subjectForm.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        axios.post('{{url("admin/subject/create")}}', formData)
            .then((response) => {
                console.log(response.data);
                window.location.href = '{{url("admin/subject/list")}}';
            }).catch((error) => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    name_error.textContent = errors.name ? errors.name[0] : "";
                    credit_hour.textContent = errors.credit_hour ? errors.credit_hour[0] : "";
                }
            })
    })
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Class</h3>
                        </div>
                        <form id="classForm">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="text-danger" id="name-error"></p>
                                    <label>Class Name</label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Class Name">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0">Active 🟢</option>
                                        <option value="1">Inactive 🔴</option>
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
    const classForm = document.getElementById('classForm');
    const name_error = document.getElementById('name-error');

    classForm.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        axios.post('{{url("admin/class/create")}}', formData)
            .then((response) => {
                window.location.href = '{{url("admin/class/list")}}';
            }).catch((error) => {
                if(error.response && error.response.status === 422){
                    const errors = error.response.data.errors;
                    name_error.textContent = errors.name ? errors.name[0] : "";
                }
            });
    });
</script>

@endsection

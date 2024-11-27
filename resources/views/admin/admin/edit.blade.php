@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Admin</h3>
                        </div>
                        <form id="adminForm" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="text-danger" id="name-error"></p>
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="email-error"></p>
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="password-error"></p>
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Update Admin</button>
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
    const adminForm = document.getElementById('adminForm');

    adminForm.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        axios.post('{{ url("admin/admin/update/".$user->id) }}', formData)
            .then(response => {
                alert('Admin updated successfully!');
                window.location.href = '{{ url("admin/admin/list") }}';
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    document.getElementById('name-error').textContent = errors.name ? errors.name[0] : '';
                    document.getElementById('email-error').textContent = errors.email ? errors.email[0] : '';
                    document.getElementById('password-error').textContent = errors.password ? errors.password[0] : '';
                }
            });
    });
</script>
@endsection

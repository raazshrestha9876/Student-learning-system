@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Admin</h3>
                        </div>
                        <form id="adminForm" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <p class="text-danger" id="name-error"></p>
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="email-error"></p>
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Email">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="password-error"></p>
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="dob-error"></p>
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" value="{{ old('dob') }}">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="address-error"></p>
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Enter Address">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="phone-error"></p>
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_no" value="{{ old('phone_no') }}" placeholder="Phone Number">
                                </div>
                                <div class="form-group">
                                    <p class="text-danger" id="profile-pic-error"></p>
                                    <label>Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_pic">
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <div>
                                        <input type="radio" name="gender" value="male"> Male
                                        <input type="radio" name="gender" value="female"> Female
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0">Active</option>
                                        <option value="1">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Add Admin</button>
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

        axios.post('{{ url("admin/admin/create") }}', formData)
            .then(response => {
                alert('Admin added successfully!');
                window.location.href = '{{ url("admin/admin/list") }}';
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    document.getElementById('name-error').textContent = errors.name ? errors.name[0] : '';
                    document.getElementById('email-error').textContent = errors.email ? errors.email[0] : '';
                    document.getElementById('password-error').textContent = errors.password ? errors.password[0] : '';
                    document.getElementById('dob-error').textContent = errors.dob ? errors.dob[0] : '';
                    document.getElementById('address-error').textContent = errors.address ? errors.address[0] : '';
                    document.getElementById('phone-error').textContent = errors.phone_no ? errors.phone_no[0] : '';
                    document.getElementById('profile-pic-error').textContent = errors.profile_pic ? errors.profile_pic[0] : '';
                }
            });
    });
</script>
@endsection

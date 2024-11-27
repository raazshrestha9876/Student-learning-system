@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Teacher</h3>
                        </div>
                        <form id="teacherForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Full Name">
                                    <p class="text-danger" id="name-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Date Of Birth</label>
                                    <input type="date" class="form-control" name="dob" value="{{ old('dob') }}" placeholder="Enter Birth Date">
                                    <p class="text-danger" id="dob-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_no" value="{{ old('phone_no') }}" placeholder="Enter Phone Number">
                                    <p class="text-danger" id="phone-no-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Appointment Date</label>
                                    <input type="date" class="form-control" name="appointment_date" value="{{ old('appointment_date') }}" placeholder="Enter Appointment Date">
                                    <p class="text-danger" id="appointment-date-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Enter Address">
                                    <p class="text-danger" id="address-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Email">
                                    <p class="text-danger" id="email-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                    <p class="text-danger" id="password-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0">Active</option>
                                        <option value="1">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gender</label><br>
                                    <input type="radio" name="gender" value="male" id="gender-male">
                                    <label for="gender-male">Male</label>
                                    <input type="radio" name="gender" value="female" id="gender-female">
                                    <label for="gender-female">Female</label>
                                    <p class="text-danger" id="gender-error"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Qualification</label>
                                    <input type="text" class="form-control" name="qualification" value="{{ old('qualification') }}" placeholder="Enter Qualification">
                                    <p class="text-danger" id="qualification-error"></p>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_pic" accept="image/*">
                                    <p class="text-danger" id="profile-pic-error"></p>
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
    document.getElementById('teacherForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        axios.post('{{ url("admin/teacher/create") }}', formData)
            .then(response => {
                console.log(response.data);
                window.location.href = '{{ url("admin/teacher/list") }}';
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    document.getElementById('name-error').textContent = errors.name ? errors.name[0] : '';
                    document.getElementById('dob-error').textContent = errors.dob ? errors.dob[0] : '';
                    document.getElementById('phone-no-error').textContent = errors.phone_no ? errors.phone_no[0] : '';
                    document.getElementById('profile-pic-error').textContent = errors.profile_pic ? errors.profile_pic[0] : '';
                    document.getElementById('appointment-date-error').textContent = errors.appointment_date ? errors.appointment_date[0] : '';
                    document.getElementById('email-error').textContent = errors.email ? errors.email[0] : '';
                    document.getElementById('password-error').textContent = errors.password ? errors.password[0] : '';
                    document.getElementById('address-error').textContent = errors.address ? errors.address[0] : '';
                    document.getElementById('qualification-error').textContent = errors.qualification ? errors.qualification[0] : '';
                    document.getElementById('gender-error').textContent = errors.gender ? errors.gender[0] : '';
                }
                console.log(error.response);
            });
    });
</script>
@endsection

@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Student</h3>
                        </div>
                        <form id="studentForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="card-body row">
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="name-error"></p>
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $student->name) }}" placeholder="Enter Full Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="roll-no-error"></p>
                                    <label>Roll No</label>
                                    <input type="number" class="form-control" name="roll_no" value="{{ old('roll_no', $student->roll_no) }}" placeholder="Enter Roll Number" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="dob-error"></p>
                                    <label>Date Of Birth</label>
                                    <input type="date" class="form-control" name="dob" value="{{ old('dob', $student->dob) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="phone-no-error"></p>
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_no" value="{{ old('phone_no', $student->phone_no) }}" placeholder="Enter Phone Number" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="address-error"></p>
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address', $student->address) }}" placeholder="Enter Address" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="gender-error"></p>
                                    <label>Gender</label>
                                    <div>
                                        <input type="radio" name="gender" value="male" required> Male
                                        <input type="radio" name="gender" value="female"> Female
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="admission-no-error"></p>
                                    <label>Admission Number</label>
                                    <input type="number" class="form-control" name="admission_no" value="{{ old('admission_no', $student->admission_no) }}" placeholder="Enter Admission Number" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="admission-date-error"></p>
                                    <label>Admission Date</label>
                                    <input type="date" class="form-control" name="admission_date" value="{{ old('admission_date', $student->admission_date) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="email-error"></p>
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $student->email) }}" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <p class="text-danger" id="password-error"></p>
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Enter Password" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Class</label>
                                    <select name="class_id" class="form-control" required>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="0">Active</option>
                                        <option value="1">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <p class="text-danger" id="profile-pic-error"></p>
                                    <label>Profile Picture</label>
                                    <input type="file" class="form-control" name="profile_pic" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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
    document.getElementById('studentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        axios.post('{{ url("admin/student/update/".$student->id) }}', formData)
            .then(response => {
                console.log(response.data);
                window.location.href = '{{ url("admin/student/list") }}';
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    document.getElementById('name-error').textContent = errors.name ? errors.name[0] : '';
                    document.getElementById('roll-no-error').textContent = errors.roll_no ? errors.roll_no[0] : '';
                    document.getElementById('dob-error').textContent = errors.dob ? errors.dob[0] : '';
                    document.getElementById('phone-no-error').textContent = errors.phone_no ? errors.phone_no[0] : '';
                    document.getElementById('profile-pic-error').textContent = errors.profile_pic ? errors.profile_pic[0] : '';
                    document.getElementById('admission-no-error').textContent = errors.admission_no ? errors.admission_no[0] : '';
                    document.getElementById('admission-date-error').textContent = errors.admission_date ? errors.admission_date[0] : '';
                    document.getElementById('email-error').textContent = errors.email ? errors.email[0] : '';
                    document.getElementById('password-error').textContent = errors.password ? errors.password[0] : '';
                    document.getElementById('gender-error').textContent = errors.gender ? errors.gender[0] : '';
                    document.getElementById('address-error').textContent = errors.address ? errors.address[0] : '';
                }
                console.log(error.response);
            });
    });
</script>
@endsection

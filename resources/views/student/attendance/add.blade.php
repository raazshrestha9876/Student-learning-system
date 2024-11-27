@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4" style="font-size: 2.5rem; font-weight: bold;">Mark Attendance</h1>
    <div class="text-center mb-3">
        <video id="video" class="border rounded shadow-lg" width="640" height="480" autoplay style="border-radius: 15px;"></video>
    </div>
    <div class="text-center mb-4">
        <button id="snap" class="btn btn-success btn-lg shadow" style="padding: 10px 30px;">Capture Photo</button>
    </div>
    <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
    
    <form id="attendanceForm" action="{{ url('student/attendance/create') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="hidden" name="photo" id="photo">
        <button type="submit" class="btn btn-primary btn-lg mt-3 shadow" style="padding: 10px 30px;">Submit Attendance</button>
    </form>
    
    <div class="mt-4">
        @if(session('status'))
            <div class="alert alert-info">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            console.error("Error accessing the camera: ", err);
            alert("Could not access the camera. Please check your permissions.");
        });

    document.getElementById('snap').addEventListener('click', function() {
        context.drawImage(video, 0, 0, 640, 480);
        const dataURL = canvas.toDataURL('image/jpeg');
        document.getElementById('photo').value = dataURL;
        document.getElementById('attendanceForm').submit();
    });
</script>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }
    h1 {
        font-family: 'Arial', sans-serif;
        color: #333;
    }
    video {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    .btn {
        transition: background-color 0.3s, transform 0.2s;
        border-radius: 25px;
    }
    .btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .alert {
        font-size: 1.2rem;
        border-radius: 10px;
    }
</style>
@endsection

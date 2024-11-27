@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f0f2f5;
    }
    .hero-section {
        background-image: url('https://source.unsplash.com/1600x900/?teacher,classroom');
        background-size: cover;
        background-position: center;
        color: white;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        text-align: center;
        border-radius: 10px;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }
    .hero-text {
        position: relative;
        z-index: 1;
    }
    .section-title {
        font-size: 3rem;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }
    .section-content {
        padding: 30px 15px;
    }
    .card {
        border: none;
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 1.5rem;
        color: #007bff;
    }
    .card-text {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>

<div class="hero-section mb-5">
    <div class="hero-text">
        <h1 class="section-title">Welcome to the Teacher Dashboard</h1>
        <p>Empowering educators to manage their classes effectively.</p>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4" style="font-weight: bold;">Dashboard Overview</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Classes</h5>
                    <p class="card-text">8</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Assignments Given</h5>
                    <p class="card-text">12</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Students in Class</h5>
                    <p class="card-text">30</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

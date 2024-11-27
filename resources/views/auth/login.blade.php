<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">

  <style>
    body {
      background: linear-gradient(to right, #4a69bd, #6f86d6);
      color: #fff;
    }
    .login-box {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 8px;
      padding: 20px;
    }
    .card-header {
      background-color: #4a69bd;
      color: #fff;
    }
    .form-control {
      border-radius: 5px;
      border: 1px solid #4a69bd;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #6f86d6;
    }
    .btn-primary {
      background-color: #4a69bd;
      border-color: #4a69bd;
      transition: background-color 0.3s, border-color 0.3s;
    }
    .btn-primary:hover {
      background-color: #6f86d6;
      border-color: #6f86d6;
    }
    .icheck-primary input:checked ~ label:before {
      background: #4a69bd;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Student</b>Sphere</a>
    </div>
    <div class="card-body">
      @include('_message')
      <form action="{{ url('login') }}" method="post">
        {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block ">Sign In</button>
          </div>
        </div>
      </form>

      <p class="m-2">
        <a href="{{ url('forgot-password')}}" style="color: #4a69bd;">I forgot my password</a>
      </p>
    </div>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>

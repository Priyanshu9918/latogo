<style>
.faq-card {
    margin-bottom: 15px !important;
}
</style>
@extends('layouts.dashboard.master2')
@section('content')
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="breadcrumb-list">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item">Reset Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="row">

        <div class="col-md-6 login-bg">
            <div class="owl-carousel login-slide owl-theme">
                <!-- <div class="welcome-login">
                    <div class="login-banner">
                        <img src="{{ url('assets/img/login-img.png') }}" class="img-fluid" alt="Logo">
                    </div>
                    <div class="mentor-course text-center">
                        <h2>Welcome to <br>Latogo.</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                    </div>
                </div>
                <div class="welcome-login">
                    <div class="login-banner">
                        <img src="{{ url('assets/img/login-img.png') }}" class="img-fluid" alt="Logo">
                    </div>
                    <div class="mentor-course text-center">
                        <h2>Welcome to <br>Latogo.</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                    </div>
                </div>
                <div class="welcome-login">
                    <div class="login-banner">
                        <img src="{{ url('assets/img/login-img.png') }}" class="img-fluid" alt="Logo">
                    </div>
                    <div class="mentor-course text-center">
                        <h2>Welcome to <br>Latogo.</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                    </div>
                </div> -->
                @php
                $studentlogin = Helper::studentlogin();
                @endphp
                @if($studentlogin)
                <div class="welcome-login">
                    <div class="login-banner">
                        <img src="{{asset('uploads/student_login/'.$studentlogin->image)}}" class="img-fluid" alt="Logo">
                    </div>
                    <div class="mentor-course text-center">
                        <h2>{{ $studentlogin->title}}</h2>
                        <p>{{ $studentlogin->description}}</p>
                    </div>
                </div>
                @else
                <h1>No Data Found</h1>
                @endif
            </div>
        </div>


        <div class="col-md-6 login-wrap-bg">

            <div class="login-wrapper">
                <div class="loginbox">
                    <h1>Reset Password</h1>
                    <div class="reset-password">
                        <p>You can reset your password here.</p>
                    </div>
                    <form action="{{ route('ResetPasswordPost') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
                          <input type="hidden" name="email" value="{{ $data->email }}">
                      <div class="form-group">
                      
                      <div class="form-group">
                          <label class="form-control-label mb-1 mt-3">New Password</label>
                          <div class="position-relative">
                            <input id="password" name="password" placeholder="New Password" class="form-control"  type="password" value="{{old('password')}}">                         
                                <div class="position-absolute r15-t15">
                                    <i class="fa fa-eye d-none" id="togglePassword1"></i>
                                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                        <div class="form-group">
                            <label class="form-control-label mb-1 mt-3">Confirm Password</label>
                            <div class="position-relative">
                            <input id="new_password" name="password_confirmation"
                                placeholder="Confirm Password" class="form-control" type="password"
                                value="{{old('password_confirmation')}}">                       
                                <div class="position-absolute r15-t15">
                                    <i class="fa fa-eye d-none" id="togglePassword2"></i>
                                    <i class="fa fa-eye-slash" id="togglePassword3"></i>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                        <div class="d-grid">
                            <input class="btn btn-start" name="recover-submit" type="submit" value="Reset Password">
                        </div>
                    </form>
                    <div class="my-4 text-center">
                        <p class="mb-0">Back to login? <a class="theme-rose" href="{{url('/user/login')}}">Sign in</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


{{--<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<style>
.form-gap {
    padding-top: 70px;
}
</style>

<body>

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <!-- <h3><i class="fa fa-lock fa-4x"></i></h3> -->
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>

                            <form action="{{ route('ResetPasswordPost') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="email" name="email" placeholder="email address" class="form-control"
                                            type="text" value="{{old('email')}}">
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    <input id="password" name="password" placeholder="password" class="form-control"
                                        type="password" value="{{old('password')}}">
                                </div>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                        </div>
                        &nbsp;
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                            <input id="password_confirmation" name="password_confirmation"
                                placeholder="confirm password" class="form-control" type="password"
                                value="{{old('password_confirmation')}}">
                        </div>
                        @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password"
                        type="submit">
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</body>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

</html>--}}

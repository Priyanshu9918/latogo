@extends('layouts.dashboard.master2')
@section('content')
<style>
    .faq-card {
        margin-bottom: 15px !important;
    }
.text-danger{
    font-size: 14px;
}
.footer-top {
    transform: translate3d(0,0px,0) !important;
}
</style>
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="breadcrumb-list">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item">Become a Teacher</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-md-6 login-bg">
            <div class="owl-carousel login-slide owl-theme">
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
                {{--@else
                <h1>No Data Found</h1>--}}
                @endif
            </div>
        </div>

        <div class="col-md-6 login-wrap-bg">

            <div class="login-wrapper">
                <div class="loginbox">
                    <h1>Become an Integral Part of Latogo </h1>
                    @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('message') }}</div>
                    @endif
                    <form action="{{ route('teacher.store') }}" method="post" enctype="multipart/form-data">
                        @csrf()
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label">Full Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your Full Name" name="full_name" value="{{ old('full_name') }}">
                                    @error('full_name')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label">Mobile Number</label>
                                    <input type="text" class="form-control" placeholder="Enter your Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}">
                                    @error('mobile_number')<span class="text-danger">{{$message}}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <input type="email" class="form-control" placeholder="Enter your email address" name="email" value="{{ old('email') }}">
                            @error('email')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <div class="position-relative">
                            <input type="password" class="form-control" id="password" placeholder="******" name="password" value="{{ old('password') }}">
                                <div class="position-absolute r15-t15">
                                <a href="javascript:void(0)"><i class="fa fa-eye d-none" id="togglePassword1"></i></a>
                                    <a href="javascript:void(0)"><i class="fa fa-eye-slash" id="togglePassword"></i></a>
                                </div>
                            </div>
                            @error('password')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Resume</label>
                            <input style="min-height: auto;" type="file" class="form-control" placeholder="Select resume here" name="resume" value="{{ old('resume') }}">
                            @error('resume')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" placeholder="Write down here" rows="4" name="message">{{ old('message') }}</textarea>
                            @error('message')<span class="text-danger">{{$message}}</span>@enderror
                        </div>

                        <div class="form-check remember-me">
                            <label class="form-check-label mb-0">
                                <input class="form-check-input" type="checkbox" name="remember" required>
                                I agree to the <a href="{{url('terms-conditions')}}" target="_blank">Terms of Service</a> and <a href="{{url('privacy-policy')}}" target="_blank">Privacy Policy.</a>
                            </label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-start" type="submit">Create Account</button>
                        </div>
                    </form>
                </div>
                <div class="google-bg text-center d-none">
                    <span><a href="#">Or sign in with</a></span>
                    <div class="sign-google">
                        <ul>
                            <li><a href="#"><img src="assets/img/net-icon-01.png" class="img-fluid" alt="Logo">
                                    Sign In using Google</a></li>
                            <li><a href="#"><img src="assets/img/net-icon-02.png" class="img-fluid" alt="Logo">Sign In using Facebook</a></li>
                        </ul>
                    </div>
                    <p class="mb-0">Already have an account? <a href="login.html">Sign in</a></p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

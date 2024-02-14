@extends('layouts.dashboard.master2')
@section('content')
<style>
    .faq-card {
        margin-bottom: 15px !important;
    }
    .text-danger{
        font-size: 14px;
    }
    .sign-google ul li:first-child a{
        border:none ;
    }
    </style>
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="breadcrumb-list">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item">Login</li>
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
                <div class=" text-center">
                    <div class="sign-google ">
                        <ul>
                            <li><a href="{{ url('authorized/google') }}"><img src="{{asset('assets/img/net-icon-01.png')}}" class="img-fluid" alt="Logo">
                                    Sign In using Google</a></li>
                            {{-- <li><a href="{{ url('redirect') }}"><img src="{{asset('assets/img/net-icon-02.png')}}" class="img-fluid" alt="Logo">Sign In using Facebook</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="loginbox pt-2">
                    <h1>Login </h1>
                    <div class="row">
                        <div class="col-12">
                            @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                        </div>
                    </div>
                    <form method="post" action="{{route('user.dologin')}}" class="singin-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" placeholder="Enter your email address" value="{{ old('email') }}">
                            @error('email')
                            <p class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control  @error('email') is-invalid @enderror" name="password" id="password" placeholder="Enter your password here">
                                <div class="position-absolute r15-t15">
                                    <a href="javascript:void(0)"><i class="fa fa-eye d-none" id="togglePassword1"></i></a>
                                    <a href="javascript:void(0)"><i class="fa fa-eye-slash" id="togglePassword"></i></a>
                                </div>
                            </div>

                            @error('password')
                            <p class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="forgot">
                            <span><a class="forgot-link" href="{{route('ForgetPasswordGet')}}">Forgot Password ?</a></span>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-start" type="submit">Login</button>
                        </div>
                    </form>
                    <div class="my-4 text-center">
                        <p class="mb-0">New User ? <a class="theme-rose" href="{{url('/student/register')}}">Create an Account</a></p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

<style>
    .faq-card {
        margin-bottom: 15px !important;
    }
    .text-danger{
        font-size: 14px;
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
                @else
                <h1>No Data Found</h1>
                @endif
            </div>
        </div>

                
                <div class="col-md-6 login-wrap-bg">

                <div class="login-wrapper">
                <div class="loginbox">
                <h1>Forgot Password ?</h1>
                <div class="reset-password">
                <p>Enter your email to reset your password.</p>
                @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                </div>
                <form action="{{ route('ForgetPasswordPost') }}" method="POST">
                @csrf
                <div class="form-group">
                <!-- <label class="form-control-label">Email</label> -->
                <input type="email" class="form-control" name="email" placeholder="Enter your email address">
                </div>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <div class="d-grid">
                <button class="btn btn-start" type="submit">Submit</button>
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

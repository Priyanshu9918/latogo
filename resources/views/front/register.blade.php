@extends('layouts.dashboard.master2')
@section('content')

<style>
.text-danger{
    font-size: 14px;
}
[data-aos=fade-up] {
    transform: translate3d(0,0px,0);
}
.r15-t15{
    right: 15px;
    top: 15px;
}
.sign-google ul li:first-child a{
    border:none ;
}
</style>
<div class="pre-loader" style="display: block;"></div>
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="breadcrumb-list">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                    <li class="breadcrumb-item">Register </li>
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
                        <p>{{ $studentlogin->description }}</p>
                    </div>
                </div>
              
                {{--@else
                <h1>NO Data Found</h1>--}}
                @endif
            </div>
        </div>
        <div class="col-md-6 login-wrap-bg">
            <div class="login-wrapper">
                <div class=" text-center">
                  
                    <div class="sign-google">
                        <ul>
                            <li><a href="{{ url('authorized/google') }}"><img src="{{asset('assets/img/net-icon-01.png')}}" class="img-fluid" alt="Logo">
                                    Sign In using Google</a></li>
                            {{-- <li><a href="{{ url('redirect') }}"><img src="{{asset('assets/img/net-icon-02.png')}}" class="img-fluid" alt="Logo">Sign In using Facebook</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="loginbox pt-2">
                    <h1>Register </h1>
                    <form action="{{ route('student.register') }}" method="POST" id="createFrm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Full Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email address">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                        </div>
                        <?php if(isset($reffer_code))
                        { ?>
                        <div class="form-group">
                        <input type="hidden" class="form-control" name="reffer_codes" value="{{ $reffer_code }}" readonly>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="form-control-label">Mobile number</label>
                            <input type="text" class="form-control" name="phone" placeholder="Enter your phone">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password here" autocomplete="new-password">
                                <div class="position-absolute r15-t15">
                                    <a href="javascript:void(0)"><i class="fa fa-eye d-none" id="togglePassword1"></i></a>
                                    <a href="javascript:void(0)"><i class="fa fa-eye-slash" id="togglePassword"></i></a>
                                </div>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-password"></p>
                        </div>
                        <div class="form-check remember-me">
                            <label class="form-check-label mb-0">
                                <input class="form-check-input" type="checkbox" name="term" value="1"> I agree to the
                                <a href="{{url('terms-conditions')}}">Terms of Service</a> and <a href="{{url('privacy-policy')}}">Privacy Policy.</a>
                            </label>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-term"></p>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-start" type="submit">Create Account</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('.pre-loader').hide();
    });
</script>
<script>
    $(document).ready(function(){
        //on change country

        $(document).on('submit', 'form#createFrm', function(event) {
            event.preventDefault();
            //clearing the error msg
            $('#sbtn').disabled = true;
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled', true);
            $('.form-control').attr('readonly', true);
            $('.form-control').addClass('disabled-link');
            $('.error-control').addClass('disabled-link');
            if ($('.submit').html() !== loadingText) {
                $('.submit').html(loadingText);
            }
            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    window.setTimeout(function() {
                        $('.submit').attr('disabled', false);
                        $('.form-control').attr('readonly', false);
                        $('.form-control').removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');
                        $('.submit').html('Save');
                    }, 2000);
                    //console.log(response);
                    if (response.success == true) {
                        //notify
                        toastr.success("Student created Successfully");
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Student Created Successfully',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // })
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}" + "/student/my-classes";
                        }, 2000);

                    }
                    //show the form validates error
                    if (response.success == false) {
                        for (control in response.errors) {
                            var error_text = control.replace('.', "_");
                            $('#error-' + error_text).html(response.errors[control]);
                            // $('#error-'+error_text).html(response.errors[error_text][0]);
                            // console.log('#error-'+error_text);
                        }
                        // console.log(response.errors);
                    }
                },
                error: function(response) {
                    // alert("Error: " + errorThrown);
                    console.log(response);
                }
            });
            event.stopImmediatePropagation();
            return false;
        });
    });
</script>
@endpush

@extends('layouts.student.master1')
@section('content')
<style>
    .mw-80 {
        max-width: 80px;
    }

    .student-ticket-view {
        width: 70%;
    }

    .cart-item-count {
        position: absolute;
        top: -5px;
        left: -60px;
        display: block;
        overflow: hidden;
        min-width: 26px;
        line-height: 26px;
        font-size: 12px;
        font-weight: 400;
        color: #242424;
        background: #f6697b;
        text-align: center;
        border-radius: 100%;
    }
</style>
<iv class="col-xl-9 col-md-8">
    <div class="settings-widget profile-details">

        <div class="checkout-form personal-address">
            <div class="personal-info-head">
                <h4>Change Password</h4>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <form id="change-password" action="{{route('student.change.password')}}" method="Post">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Current password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password" placeholder="Enter your Current password" name="current_password">
                                <div class="position-absolute r15-t15">
                                    <i class="fa fa-eye d-none" id="togglePassword1"></i>
                                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-current_password"></p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">New Password</label>
                            <div class="position-relative">
                            <input type="password" class="form-control pass-input" id="new_password" placeholder="Enter your New password" name="new_password">
                                <div class="position-absolute r15-t15">
                                    <i class="fa fa-eye d-none" id="togglePassword2"></i>
                                    <i class="fa fa-eye-slash" id="togglePassword3"></i>
                                </div>
                            </div>
                            <div class="pass-group" id="passwordInput">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-new_password"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Confirm New Password</label>
                            <div class="position-relative">
                            <input type="password" class="form-control" id="c_new_password" placeholder="Confirm New Password" name="new_confirm_password">
                                <div class="position-absolute r15-t15">
                                    <i class="fa fa-eye d-none" id="togglePassword5"></i>
                                    <i class="fa fa-eye-slash" id="togglePassword4"></i>
                                </div>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-new_confirm_password"></p>
                        </div>
                        <div class="update-profile save-password">
                            <button type="submit" class="btn btn-primary">Save Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
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
            $(document).on('click', '#togglePassword', function (event) {
                document.getElementById('password').type = 'text';
                var element = document.getElementById("togglePassword");
                element.classList.add("d-none");
                var element = document.getElementById("togglePassword1");
                element.classList.remove("d-none");
                });
                $(document).on('click', '#togglePassword1', function (event) {
                    document.getElementById('password').type = 'password';
                    var element = document.getElementById("togglePassword1");
                    element.classList.add("d-none");
                    var element = document.getElementById("togglePassword");
                    element.classList.remove("d-none");
            });
            $(document).on('click', '#togglePassword3', function (event) {
                document.getElementById('new_password').type = 'text';
                var element = document.getElementById("togglePassword3");
                element.classList.add("d-none");
                var element = document.getElementById("togglePassword2");
                element.classList.remove("d-none");
                });
                $(document).on('click', '#togglePassword2', function (event) {
                    document.getElementById('new_password').type = 'password';
                    var element = document.getElementById("togglePassword2");
                    element.classList.add("d-none");
                    var element = document.getElementById("togglePassword3");
                    element.classList.remove("d-none");
            });
            $(document).on('click', '#togglePassword4', function (event) {
                document.getElementById('c_new_password').type = 'text';
                var element = document.getElementById("togglePassword4");
                element.classList.add("d-none");
                var element = document.getElementById("togglePassword5");
                element.classList.remove("d-none");
                });
                $(document).on('click', '#togglePassword5', function (event) {
                    document.getElementById('c_new_password').type = 'password';
                    var element = document.getElementById("togglePassword5");
                    element.classList.add("d-none");
                    var element = document.getElementById("togglePassword4");
                    element.classList.remove("d-none");
            });
        $(document).on('submit', 'form#change-password', function(event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
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
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Password Successfully updated!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        // redirect to google after 5 seconds
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}" + "student/student-change-password";
                        }, 2000);
                        location.reload();
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
    </script>
    @endpush

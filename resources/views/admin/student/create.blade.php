@extends('layouts.admin.master')
@section('content')
<style>
  .r15-t15{
    right: 15px;
    top: 10px;
}
</style>
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Student</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Add Student</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{route('admin.student.create')}}" method="POST" id="createFrm" enctype="multipart/form-data">
                            @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Full Name</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <input type="text" class="form-control" name="name" id="basic-icon-default-name"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Email</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                             
                              <input type="email" class="form-control" name="email" id="basic-icon-default-email" />
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Mobile Number</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <input type="number" class="form-control" name="phone" id="basic-icon-default-phone"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Password</label>
                          <div class="col-sm-8">
                            <div class="form-group form-group-merge position-relative">
                                <input type="password" class="form-control" id="password" name="password" id="basic-icon-default-password"/>
                                  <div class="position-absolute r15-t15">
                                      <a href="javascript:void(0)"><i class="fa fa-eye d-none" id="togglePassword1"></i></a>
                                      <a href="javascript:void(0)"><i class="fa fa-eye-slash" id="togglePassword"></i></a>
                                  </div>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-password"></p>
                          </div>
                        </div>
                        <!-- <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname"></label>
                          <div class="col-sm-8">
                          <input type="checkbox" id="popular" name="popular" value="1">
                            <label for="popular"> Check It If make it popular</label><br></div>
                        </div> -->
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Create</button>
                          </div>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
@endsection
@push('script')
<script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
<script>
    $(document).ready(function(){
        //on change country
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
        $(document).on('submit', 'form#createFrm', function (event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled',true);
            $('.form-control').attr('readonly',true);
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
                success: function (response) {
                    window.setTimeout(function(){
                        $('.submit').attr('disabled',false);
                        $('.form-control').attr('readonly',false);
                        $('.form-control').removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');
                        $('.submit').html('Save');
                      },2000);
                    //console.log(response);
                    if(response.success==true) {
                        //notify
                        toastr.success("Student created Successfully");

                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Student Created Successfully',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        //     })
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/student";
                        }, 2000);

                    }
                    //show the form validates error
                    if(response.success==false ) {
                        for (control in response.errors) {
                           var error_text = control.replace('.',"_");
                           $('#error-'+error_text).html(response.errors[control]);
                           // $('#error-'+error_text).html(response.errors[error_text][0]);
                           // console.log('#error-'+error_text);
                        }
                        // console.log(response.errors);
                    }
                },
                error: function (response) {
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

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Teacher</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Edit Teacher</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('admin.teacher.edit',['id'=>base64_encode($teacher->id)]) }}" method="POST" id="editFrm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Full Name</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="name" value="{{$teacher->name}}" id="basic-icon-default-name"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Email</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="email" class="form-control" name="email" value="{{$teacher->email}}" id="basic-icon-default-email" readonly/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Mobile Number</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="number" class="form-control" name="phone" value="{{$teacher->phone}}" id="basic-icon-default-phone"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Resume</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="file" class="form-control" name="resume" id="basic-icon-default-resume"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-resume"></p>
                            @if($teacher->resume!=NULL && file_exists(public_path('upload/resume/'.$teacher->resume)))
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <a type="button" class="btn btn-secondary btn-sm" href="{{asset('upload/resume/'.$teacher->resume)}}" target="_blank" style="width:108px;">
                                          view
                                        </a>
                                    </div>
                                </div>
                            @endif
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Password</label>
                          <div class="col-sm-8">
                          <div class="form-group form-group-merge position-relative">
                              <input type="password" class="form-control" id="password" name="password" value="{{$teacher->plan_password}}" id="basic-icon-default-password"/>
                              <div class="position-absolute r15-t15">
                                      <a href="javascript:void(0)"><i class="fa fa-eye d-none" id="togglePassword1"></i></a>
                                      <a href="javascript:void(0)"><i class="fa fa-eye-slash" id="togglePassword"></i></a>
                                  </div>
                                </div>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-password"></p>
                          </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Message</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <textarea type="number" class="form-control" name="message" id="basic-icon-default-message">{{$teacher->message}}</textarea>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-message"></p>
                          </div>
                        </div>
                        </div>
                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
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
<link src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css"></link>
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

        $(document).on('submit', 'form#editFrm', function (event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");
            $('.pre-loader').show();

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled',true);
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
                        $('.form-control').removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');
                        $('.submit').html('Update');
                      },2000);
                    //console.log(response);
                    if(response.success==true) {

                        //notify
                        // toastr.success("blog Updated Successfully");
                        toastr.success("Teacher Updated Successfully");
                        // redirect to google after 5 seconds
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/teacher";
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
                    $('.pre-loader').hide();
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
    $(document).ready(function() {
          $('.summernote').summernote();
        });
</script>
@endpush

@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Courses Banner</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Add  Courses Banner</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{route('admin.course.create')}}" method="POST" id="createFrm" enctype="multipart/form-data">
                            @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Course Title</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="title" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-title"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Total Course</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="course" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Total Country</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="country" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-country"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Total Appreciations</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="appreciations" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-appreciations"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Course Image</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="file" class="form-control" name="image" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-image"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Description</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <textarea class="summernote" name="description" ></textarea>                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script>
    $(document).ready(function(){
        //on change country

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
                        toastr.success("Course created Successfully");
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'course Created Successfully',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        //     })
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/course";
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
    $(document).ready(function() {
      $('.summernote').summernote();
    });
</script>
@endpush

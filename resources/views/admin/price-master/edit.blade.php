@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Price Master</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-iPrice Mastertems-center justify-content-between">
                      <h5 class="mb-0">Edit Price Master</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('admin.price-master.edit',['id'=>base64_encode($price->id)]) }}" method="POST" id="editFrm" enctype="multipart/form-data">
                            @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Title</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="title" id="basic-icon-default-fullname" value="{{$price->title}}">
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-title"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Short Title</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="short_title" id="basic-icon-default-fullname" value="{{$price->short_title}}">
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-short_title"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Images</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="file" class="form-control" name="icon" id="basic-icon-default-fullname" value="{{$price->icon}}"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-icon"></p>
                          </div>
                          @if($price->icon!=NULL && file_exists(public_path('uploads/price/'.$price->icon)))
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <a href="{{asset('uploads/price/'.$price->icon)}}" target="_blank">
                                            <img src="{{asset('uploads/price/'.$price->icon)}}" width="100px" height="100px">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Time</label>
                          <div class="col-sm-8">
                          <select class="form-control total_classes" name="time" id="time">
                            <option value="1" @if($price->time==1) selected @endif>Yes</option>
                            <option value="0" @if($price->time==0) selected @endif>No</option>
                          </select>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time"></p>
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

        $(document).on('submit', 'form#editFrm', function (event) {
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
                        $('.submit').html('Update');
                      },2000);
                    //console.log(response);
                    if(response.success==true) {

                        //notify
                        toastr.success("Price master updated Successfully");
                        // Swal.fire({
                        // position: 'top-end',
                        // icon: 'success',
                        // title: 'Price Master Updated Successfully',
                        // showConfirmButton: false,
                        // timer: 1500
                        // })
                        // redirect to google after 5 seconds
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/price-master";
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
@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Quiz</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Edit Quiz Test</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('admin.quize.edit',['id'=>base64_encode($quize->id)]) }}" method="POST" id="editFrm" enctype="multipart/form-data">
                            @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="text" class="form-control" name="name" id="basic-icon-default-fullname" value="{{$quize->name ?? ''}}"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Image</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="file" class="form-control" name="icon" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-icon"></p>
                          </div>
                          @if($quize->image!=NULL && file_exists(public_path('uploads/quize/'.$quize->image)))
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <a href="{{asset('uploads/quize/'.$quize->image)}}" target="_blank">
                                          <img src="{{asset('uploads/quize/'.$quize->image)}}" width="100px" height="100px">
                                      </a>
                                  </div>
                              </div>
                          @endif
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Sub Name</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <select class="form-select" name="parent_category" id="parent">
                                    <option value="">Select</option>
                                    @if(count($parent_quize)>0)
                                        @foreach ($parent_quize as $cat)
                                            <option value="{{$cat->id}}" @if($cat->id==$quize->parent) selected @endif>{{$cat->name}}</option>
                                        @endforeach
                                    @endif
                                </select>                            
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-parent_category"></p>
                          </div>
                        </div>
                        <div class="row mb-3 d-none" id="url1">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Url</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <textarea class="form-control url12" name="url" id="basic-icon-default-fullname">{{$quize->url}}</textarea>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-url"></p>
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
        var parent = $('#parent').val();
        if(parent != ''){
          $('#url1').removeClass('d-none');
        }

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
                        toastr.success("Quiz Updated Successfully");
                        // redirect to google after 5 seconds
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/quize";
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
    $(document).on('change', '#parent', function (event) {
        var parent = $('#parent').val();
        if(parent != ''){
          $('#url12').val('');
          $('#url1').removeClass('d-none');
        }else{
          $('#url12').val('');
          $('#url1').addClass('d-none');
        }
        return false;
    });
</script>
@endpush

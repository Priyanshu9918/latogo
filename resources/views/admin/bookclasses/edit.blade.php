@extends('layouts.admin.master')
@section('content')
<style>
  /* Base setup */
@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
h1 {
    font-size: 2em; 
    margin-bottom: .5rem;
}

/* Ratings widget */
.rate {
    display: inline-block;
    border: 0;
}
/* Hide radio */
.rate > input {
    display: none;
}
/* Order correctly by floating highest to the right */
.rate > label {
    float: right;
}
/* The star of the show */
.rate > label:before {
    display: inline-block;
    font-size: 1.1rem;
    padding: .3rem .2rem;
    margin: 0;
    cursor: pointer;
    font-family: FontAwesome;
    content: "\f005 "; /* full star */
}
/* Zero stars rating */
.rate > label:last-child:before {
    content: "\f006 "; /* empty star outline */
}
/* Half star trick */
.rate .half:before {
    content: "\f089 "; /* half star no outline */
    position: absolute;
    padding-right: 0;
}
/* Click + hover color */
input:checked ~ label, /* color current and previous stars on checked */
label:hover, label:hover ~ label { color: #fff816;  } /* color previous stars on hover */

/* Hover highlights */
input:checked + label:hover, input:checked ~ label:hover, /* highlight current and previous stars */
input:checked ~ label:hover ~ label, /* highlight previous selected stars for new rating */
label:hover ~ input:checked ~ label /* highlight previous selected stars */ { color: #fff816;  } 
</style>
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Booking Classes</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Booking Classes</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.bookclasses.edit',['id'=>base64_encode($new->id)]) }}" method="POST" id="editFrm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Teacher</label>
                                <div class="col-sm-8">
                                    <select class="form-control total_classes" name="teacher_id" id="teacher_id">
                                        <option value="">select teacher</option>
                                        @if(count($teacher)>0)
                                        @foreach ($teacher as $tech)
                                            <option value="{{$tech->id}}"@if($tech->id==$new->teacher_id) selected @endif>{{$tech->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-teacher_id"></p>
                                </div>
                            </div>
                            @if($new->is_featured==1)
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Is_featured</label>
                                <div class="col-sm-8">
                                    <select class="form-control total_classes" name="is_featured" id="is_featured">
                                        <option value="{{$new->is_featured}}">YES</option>
                                        <option value="0">No</option>

                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-is_featured"></p>
                                </div>
                            </div>
                            @else
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Is_featured</label>
                                <div class="col-sm-8">
                                    <select class="form-control total_classes" name="is_featured" id="is_featured">
                                        <option value="{{$new->is_featured}}">No</option>
                                        <option value="1">yes</option>

                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-is_featured"></p>
                                </div>
                            </div>
                            @endif
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Youtube Url</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                                        <input type="text" class="form-control" name="youtube_url" id="basic-icon-default-fullname" value="{{$new->youtube_url}}">
                                    </div>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-youtube_url"></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Teaches</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                                        <input type="text" class="form-control" name="teaches" id="basic-icon-default-fullname" value="{{$new->teaches??''}}">
                                    </div>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-teaches"></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Student Count</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                                        <input type="text" class="form-control" name="student_count" id="basic-icon-default-fullname" value="{{$new->student_count}}">
                                    </div>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-student_count"></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lessons</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                                        <input type="text" class="form-control" name="lessons" id="basic-icon-default-fullname" value="{{$new->lessons}}">
                                    </div>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-lessons"></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Success</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                                        <input type="text" class="form-control" name="success" id="basic-icon-default-fullname" value="{{$new->success}}">
                                    </div>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-success"></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Description</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                                        <textarea type="text" class="form-control" name="description" id="basic-icon-default-fullname">{{$new->description}}</textarea>
                                    </div>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Rating</label>
                                <div class="col-sm-8">
                                <fieldset class="rate">
                                <input type="radio" id="rating10" name="rating" value="10" @if($new->rating == 10) checked @endif><label for="rating10" title="5 stars"></label>
                                <input type="radio" id="rating9" name="rating" value="9"   @if($new->rating == 9) checked @endif><label class="half" for="rating9" title="4 1/2 stars"></label>
                                <input type="radio" id="rating8" name="rating" value="8"   @if($new->rating == 8) checked @endif><label for="rating8" title="4 stars"></label>
                                <input type="radio" id="rating7" name="rating" value="7"   @if($new->rating == 7) checked @endif><label class="half" for="rating7" title="3 1/2 stars"></label>
                                <input type="radio" id="rating6" name="rating" value="6"   @if($new->rating == 6) checked @endif><label for="rating6" title="3 stars"></label>
                                <input type="radio" id="rating5" name="rating" value="5"   @if($new->rating == 5) checked @endif><label class="half" for="rating5" title="2 1/2 stars"></label>
                                <input type="radio" id="rating4" name="rating" value="4"   @if($new->rating == 4) checked @endif><label for="rating4" title="2 stars"></label>
                                <input type="radio" id="rating3" name="rating" value="3"   @if($new->rating == 3) checked @endif><label class="half" for="rating3" title="1 1/2 stars"></label>
                                <input type="radio" id="rating2" name="rating" value="2"   @if($new->rating == 2) checked @endif><label for="rating2" title="1 star"></label>
                                <input type="radio" id="rating1" name="rating" value="1"   @if($new->rating == 1) checked @endif><label class="half" for="rating1" title="1/2 star"></label>
                                </fieldset>
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-rating"></p>
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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
            <link src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
            </link>
            <script>
                $(document).ready(function() {
                    //on change country

                    $(document).on('submit', 'form#editFrm', function(event) {
                        event.preventDefault();
                        //clearing the error msg
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
                                    $('.submit').html('Update');
                                }, 2000);
                                //console.log(response);
                                if (response.success == true) {

                                    //notify
                                    toastr.success("Booking Classes Updated Successfully");
                                    // Swal.fire({
                                    //     position: 'top-end',
                                    //     icon: 'success',
                                    //     title: 'Booking Classes  new Updated Successfully',
                                    //     showConfirmButton: false,
                                    //     timer: 1500
                                    // })
                                    // redirect to google after 5 seconds
                                    window.setTimeout(function() {
                                        window.location = "{{ url('/')}}" + "/admin/bookclasses";
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
                $(document).ready(function() {
                    $('.summernote').summernote();
                });
            </script>
            @endpush

@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Manage Pricing</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-iPricingtems-center justify-content-between">
                      <h5 class="mb-0">Edit Pricing</h5>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('admin.pricing.edit',['id'=>base64_encode($price->id)]) }}" method="POST" id="editFrm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Price Master</label>
                          <div class="col-sm-8">
                                <select class="form-control total_classes" name="price_master" id="price_master" >
                                    <option value="">Select Price Master</option>
                                    @if(count($price_master)>0)
                                        @foreach ($price_master as $cat)
                                            <option value="{{$cat->id}}"@if($cat->id==$price->price_master) selected @endif>{{$cat->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-title"></p>
                          </div>
                        </div>
                        @php 
                          $time = DB::table('price_masters')->where('id',$price->price_master)->where('status','<>',2)->first();
                        @endphp
                        <div class="row mb-3 @if($time->time == 1) '' @else d-none @endif" id="ti">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Time</label>
                          <div class="col-sm-8">
                                <select class="form-control total_classes" name="time" id="time">
                                    <option value="">Please Choose Time</option>
                                    <option value="30" @if($price->time==30) selected @endif>30</option>
                                    <option value="45" @if($price->time==45) selected @endif>45</option>
                                    <option value="60" @if($price->time==60) selected @endif>60</option>
                                    <option value="90" @if($price->time==90) selected @endif>90</option>
                                </select>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Total Class</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="number" class="form-control totle_class" name="total_classes" id="total_classes" value="{{$price->totle_class}}"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger class1" id="cl1"></p>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-total_classes"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Price</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="number" class="form-control" name="price" id="price" value="{{$price->price}}"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-price"></p>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Total Price</label>
                          <div class="col-sm-8">
                            <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                              <input type="number" class="form-control total_price" name="total_price" value="{{$price->total_price}}" id="basic-icon-default-fullname"/>
                            </div>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-total_price"></p>
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
        $('#price_master').on('change', function() {
            var active = this.value;
            $.ajax({
            url: "{{ route('admin.time') }}",
            type: "get",
            data: {
                'active': active,
            },
            success: function(response) {
                console.log(response);
                if(response.success==true) {
                    $('#ti').removeClass('d-none')
                }
                if(response.success==false) {
                    $('#ti').addClass('d-none')
                }
                }
            });
        });
        $('#price').on('keyup', function() {
            var active = this.value;
            var t_class = $('.totle_class').val();
            if(t_class == '')
            {
                $('#cl1').html('please enter Firstly Total Class');
            }else{
                var total = active * t_class;
                $('.total_price').val(total);
            }
            });
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
                        toastr.success("Pricing updated Successfully");
                        // Swal.fire({
                        // position: 'top-end',
                        // icon: 'success',
                        // title: 'Pricing Updated Successfully',
                        // showConfirmButton: false,
                        // timer: 1500
                        // })
                        // redirect to google after 5 seconds
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/pricing";
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

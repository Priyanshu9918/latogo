
@extends('layouts.student.master1')
@section('content')
<style>
    .mw-80 {
        max-width: 80px;
    }
    .student-ticket-view {
        width: 70%;
    }
	.google-btn{
		border: 1px solid #e5e5e5;
		border-radius: 5px;
		font-weight: 600;
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
                    <div class="col-xl-9 col-md-8">
                        <div class="settings-widget profile-details">
                            <div class="settings-menu p-0">
                                <div class="profile-heading">
                                    <h3>Profile Details</h3>
                                    <p>You have full control to manage your own account setting.</p> 
                                </div>
                                <div class="course-group mb-0 d-flex">
                                    <div class="course-group-img d-flex align-items-center">
                                        @if(isset($student1->avtar))
                                            <a><img src="{{asset('uploads/user/avatar/'.$student1->avtar)}}" alt=""
                                                    class="img-fluid"></a>
                                        @else
                                        <img src="{{asset('assets/user.jpg')}}" alt=""
                                                    class="img-fluid">
                                        @endif
                                        <div class="course-name">
                                            <h4><a href="student-profile.html">Your avatar</a></h4>
                                            <p>PNG or JPG no bigger than 800px wide and tall.</p>
                                        </div>
                                    </div>
                                    <div class="profile-share d-flex align-items-center justify-content-center">
                                        <a href="javascript:;" class="btn btn-success profile" id="profile">Update</a>
                                        @if(isset($student1->id))
                                        <input type="hidden" id="p_id" value="{{$student1->id}}" name="p_id">
                                        @endif
                                        @if(isset($student1->avtar))
                                            <a href="#" class="btn btn-danger" id="delete">Delete</a>
                                        @endif
                                    </div>
                                </from>
                                </div>
                                <div class="checkout-form personal-address add-course-info ">
                                <form action="{{route('student.student-settings.create')}}" method="POST" id="createFrm" enctype="multipart/form-data">
                                    @csrf
										<div class="personal-info-head ">
											<h4 class="mb-1">Personal Details</h4>
											<p>Edit your personal information and address.</p>
										</div>
                                        <input type="file" name="avtar" id="profilephoto" class="d-none" />
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Full Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your first Name" name="first_name" value="{{$student->name ?? ''}}">
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-first_name"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Phone</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your phone number" name="phone" value="{{$student->phone ?? ''}}">
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Email</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your Email" name="email" value="{{$student->email ?? ''}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Address</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your Address" name="address" value="{{$student1->address1 ?? ''}}">
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-address" ></p>
                                                </div>
                                            </div>
											<div class="col-lg-6">
												<div class="form-group">
													<label class="form-label">Country</label>
													<select class="form-select select country" name="country" id="country_id">
														<option value="">Select country</option>
                                                            @if(count($country)>0)
                                                                @foreach ($country as $cat)
                                                                    @if(isset($student1))
                                                                        <option value="{{$cat->id}}" @if($cat->id == $student1->country) selected @endif>{{$cat->name}}</option>
                                                                    @else
                                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
													</select>
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-country"></p>
												</div>
											</div>
                                            <div class="col-lg-6">
												<div class="form-group">
													<label class="form-label">State</label>
													<select class="form-select select Timezone-select" name="timezone" id="timezone_id">
                                                    <option value="" >Select state</option>
                                                    @if(count($timezone)>0)
                                                        @foreach ($timezone as $tiz)
                                                            @if(isset($student1))
                                                                <option value="{{$tiz->id}}" @if($tiz->id == $student1->state ?? '') selected @endif>{{$tiz->name}}</option>
                                                            @else
                                                                <option value="{{$tiz->id}}">{{$tiz->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
													</select>
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-timezone"></p>
												</div>
											</div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Postal Code</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your Postal Code" name="postal_code" value="{{$student1->postal_code ?? ''}}">
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-postal_code" ></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
												<div class="form-group">
													<label class="form-label">Time format</label>
                                                    @if(isset($student1->time_formate))
													<div class="row">
														<div class=" col-6">
														  <input class="form-check-input" type="radio" name="timeformat" id="time1" value="0" @if($student1->time_formate == 0) checked="" @endif>
														  <label class="form-check-label" for="time1">
															12 hr
														  </label>
														</div> 
														<div class=" col-6">
														  <input class="form-check-input" type="radio" name="timeformat" id="time2" @if($student1->time_formate == 1) checked="" @endif value="1">
														  <label class="form-check-label" for="time2">
															24 hr
														  </label>
														</div>
													</div>
                                                    @else
                                                    <div class="row">
														<div class=" col-6">
														  <input class="form-check-input" type="radio" name="timeformat" id="time1" value="0" >
														  <label class="form-check-label" for="time1">
															12 hr
														  </label>
														</div> 
														<div class=" col-6">
														  <input class="form-check-input" type="radio" name="timeformat" id="time2" checked value="1">
														  <label class="form-check-label" for="time2">
															24 hr
														  </label>
														</div>
													</div>
                                                    @endif
												</div>
											</div>
                                        </div>
										
										<div class="row">
											
											<div class="update-profile">
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                            </div>
										</div>
                                    </form>
                                </div>
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
        $(document).on('click','.profile',function(){
            $('#profilephoto').click();
        });

        $(document).on('click','#delete',function(){
            var id = $('#p_id').val();
            $.ajax({
                    type:"get",
                    url:"{{route('student.student-settings.delete')}}",
                    data:{'id':id},
                    success:function(response)
                    {
                        if(response.success==true) {
                        //notify
                        toastr.success("Avatar deleted Successfully");
                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Avatar deleted successfully',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        //     })
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/student/student-settings";
                        }, 2000);

                    }
                    }
                });
        });
        //on change country
        $(document).on('change','.country',function(){
            var id = $('#country_id').val();
            $.ajax({
                type:"post",
                    url:"{{route('state-list')}}",
                    data:{'country_id':id,"_token": "{{ csrf_token() }}"},
                    success:function(data)
                    {
                        $("#timezone_id").empty();
                        $("#timezone_id").html('<option value="">Select State</option>');
                        $.each(data,function(key,value){
                        $("#timezone_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                });
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
                        toastr.success("Profile Updated Successfully");

                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'Profile Updated Successfully',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        //     })
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/student/student-settings";
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

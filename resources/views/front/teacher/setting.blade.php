@extends('layouts.teacher.master')
@section('content')

<style>
span.select2.select2-container.select2-container--default:after {
    position: absolute;
    font-family: var(--fa-style-family,"Font Awesome 6 Free");
    font-weight: var(--fa-style,900);
    top: 5px;
    font-size: 14px;
    right: 10px;
    content: "\f078";
}
</style>
<div class="page-content instructor-page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-xl-9 col-md-8">
                    <div class="settings-widget profile-details">
                        @if(Session::has('error'))<div class="alert alert-danger my-toast">{{ Session::get('error') }}</div>@endif
                        @if(Session::has('success'))<div class="alert alert-success my-toast">{{ Session::get('success') }}</div>@endif
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3 class="m-0">Profile Details</h3>
                            </div>
                            <div class="course-group mb-0 d-flex">
                                <div class="course-group-img d-flex align-items-center">
                                    <a href="#">
                                        @if($ts!=null && $ts->avatar!=null)
                                            <img src="{{ asset('uploads/user/avatar/'.$ts->avatar) }}" alt="" class="img-fluid">
                                        @else
                                            <img src="{{ asset('assets/img/user/user.png') }}" alt="" class="img-fluid">
                                        @endif
                                    </a>
                                    <div class="course-name">
                                        <h4><a href="#">Your avatar</a></h4>
                                        <p>PNG or JPG no bigger than 800px wide and tall.</p>
                                        <sub class="text-capitalize text-primary">please submit to update</sub>
                                    </div>
                                </div>
                                <div class="profile-share d-flex align-items-center justify-content-center">
                                    <a href="javascript:;" id="profilephotobtn" class="btn btn-success">Upload</a>
                                    @if(isset($ts->avatar))
                                    <a href="javascript:;" class="btn btn-danger avatarDelete">Delete</a> 
                                    @endif
                                </div>
                            </div>
                            <div class="course-group mb-0 d-flex">
                                <div class="course-group-img d-flex align-items-center">
                                    <a href="#">
                                        @if($ts!=null && $ts->youtube_link!=null)
                                        <iframe width="250px" height="150px" src="{{ $ts->youtube_link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                        @else
                                       <img style="border-radius: 0 !important;max-width: max-content;" src="{{ asset('assets/img/video_player_placeholder.png') }}" alt="" />
                                        <!-- <p>YouTube Link Not Exist</p> -->
                                        @endif
                                    </a>
                                    <div class="course-name ps-3">
                                        <h4><a href="#">Introduction Video</a></h4>
                                        {{-- <p>MP4 file not bigger than 5MB size</p> --}}
                                        <p></p>
                                        <sub class="text-capitalize text-primary">please submit to update</sub>
                                    </div>
                                </div>
                                <div class="profile-share d-flex align-items-center justify-content-center">
                                    <a href="javascript:;" id="introvbtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ylinkPop">Upload</a>
                                    <a href="javascript:;" class="btn btn-danger introDelete">Delete</a>
                                </div>
                            </div>
                            <div class="checkout-form personal-address add-course-info">
                                <div class="personal-info-head">
                                    <h4>Personal Details</h4>
                                </div>
                                <form action="{{ route('teacher.setting.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf()
                                    <input type="text" name="intro_video" id="introvideo" class="d-none" value="@if($ts!=null && $ts->youtube_link!=null) {{ $ts->youtube_link }} @endif"/>
                                    <input type="file" name="avatar" id="profilephoto" class="d-none" />
                                    <input type="hidden" name="avatat-value" value="@if($ts!=null && $ts->avatar!=null){{$ts->avatar}}@endif">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Full Name</label>
                                                <input type="text" class="form-control" placeholder="Enter your Full Name" name="full_name" value="{{ Auth::user()->name }}">
                                                @error('full_name')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Last Name</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter your last Name">
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Phone</label>
                                                <input type="text" class="form-control" placeholder="Enter Your Phone" name="phone" value="{{ Auth::user()->phone }}">
                                                @error('phone')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Email</label>
                                                <input type="text" class="form-control" placeholder="Enter your Email" name="email" value="{{ Auth::user()->email }}" readonly>
                                                @error('email')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Address Line 1</label>
                                                <input type="text" class="form-control" placeholder="Address" name="address_line_1" value="{{ ($ts!=null && $ts->address_line_1!=null)?$ts->address_line_1:'' }}">
                                                @error('address_line_1')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Address Line 2
                                                    (Optional)</label>
                                                <input type="text" class="form-control" placeholder="Address" name="address_line_2" value="{{ ($ts!=null && $ts->address_line_2!=null)?$ts->address_line_2:'' }}">
                                                @error('address_line_2')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">City</label>
                                                <input type="text" class="form-control" placeholder="Enter your City" name="city" value="{{ ($ts!=null && $ts->city!=null)?$ts->city:'' }}">
                                                @error('city')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">ZipCode</label>
                                                <input type="text" class="form-control" placeholder="Enter your Zipcode" name="zipcode" value="{{ ($ts!=null && $ts->zipcode!=null)?$ts->zipcode:'' }}">
                                                @error('zipcode')<span class="text-danger">{{$message}}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="personal-info-head">
                                                <h4>Languages </h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                {{-- <input type="text" class="form-control" placeholder="Enter Languages here" name="language" value="{{ ($ts!=null && $ts->language!=null)?$ts->language:'' }}"> --}}
                                                <select class="form-control select2" name="language[]" multiple>
                                                    <option value="">Select Language</option>
                                                    @foreach ($lng as $lan)
                                                        <option value="{{ $lan->id }}" @if($ts!=null && $ts->language!=null && in_array($lan->id,json_decode($ts->language))) selected @endif>{{ $lan->language }}</option>
                                                    @endforeach
                                                </select>
                                                @error('language')<span class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                         <div class="personal-info-head">
                                                <h4>About me</h4>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">About me  </label>
                                                    <textarea class="form-control sn-editor" name="about_me">{{ ($ts!=null && $ts->about_me!=null)?$ts->about_me:'' }}</textarea>
                                                    @error('about_me')<span class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Teacher headline </label>
                                                    <textarea class="form-control sn-editor" name="teacher_headline">{{ ($ts!=null && $ts->teacher_headline!=null)?$ts->teacher_headline:'' }}</textarea>
                                                    @error('teacher_headline')<span class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Me as a teacher</label>
                                                    <textarea class="form-control sn-editor" name="me_as_teacher">{{ ($ts!=null && $ts->me_as_teacher!=null)?$ts->me_as_teacher:'' }}</textarea>
                                                    @error('me_as_teacher')<span class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">My lessons and teaching style</label>
                                                    <textarea class="form-control sn-editor" name="my_lession_and_teaching_style">{{ ($ts!=null && $ts->my_teaching_style!=null)?$ts->my_teaching_style:'' }}</textarea>
                                                    @error('my_lession_and_teaching_style')<span class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                        <div class="update-profile">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
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
<div class="modal fade" id="ylinkPop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Youtube Link Configration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="introVideoField" placeholder="YouTube Link">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="introVideoFieldOk">OK</button>
        </div>
      </div>
    </div>
</div>


@push('script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.sn-editor').summernote();
    });

	$('#introVideoFieldOk').click(function(){
        var lnk = $.trim($('#introVideoField').val());
        if(lnk!='')
        {
            $('#introvideo').val(lnk);
        }

	});
	$('#profilephotobtn').click(function(){
		$('#profilephoto').click();
	});
    $("#profilephoto").change(function(){

    });
    $(document).on('click','.avatarDelete',function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You really want to delete your avatar !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Please submit form get the changes',
                // 'success'
                );

                $('input[name=avatat-value]').val('');
            }
        })
    });
    $(document).on('click','.introDelete',function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You really want to delete intro video link !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Please submit form get the changes',
                // 'success'
                );

                $('#introvideo').val('');
            }
        })
    });

</script>
@endpush
@endsection

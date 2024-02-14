@extends('layouts.teacher.master')
@section('content')
<style>
   .no_order_div i {
        font-size: 50px;
    }
</style>
<div class="pre-loader" style="display: block;"></div>
<div class="page-content instructor-page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3  d-flex">
                        <div class="card instructor-card w-100">
                            <div class="card-body align-items-center justify-content-center d-flex">
                                <div>
                                    @if(auth()->user()->TeacherSetting!=null && auth()->user()->TeacherSetting->avatar
                                    &&
                                    File::exists(public_path('uploads/user/avatar/'.auth()->user()->TeacherSetting->avatar)))
                                    <a><img class="avtar-style" src="{{ asset('uploads/user/avatar/'.auth()->user()->TeacherSetting->avatar) }}"
                                            alt=""></a>
                                    @else
                                    <img  class="avtar-style" src="{{ asset('assets/img/user/user.png') }}" alt="">
                                    @endif

                                </div>
                                <div class="instructor-inner">
                                    @php $user = Auth::user()->load('TeacherSetting.TimeZone') @endphp
                                    <h4 class="fs-18">{{ $user->name }}</h4>
                                    <p>User ID : {{ $user->id}}</p>
                                    <p>{{$cur_time}} (UTC {{$user_timezone->raw_offset }}.00)</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 d-flex">
                        <div class="card instructor-card w-100">
                            <div class="card-body text-center align-items-center justify-content-center d-flex">
                                <div class="instructor-inner">
                                    <h4 class="">{{ count($upcommit) }}</h4>
                                    <p>Upcoming Lessons</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex">
                        <div class="card instructor-card w-100">
                            <div class="card-body text-center align-items-center justify-content-center d-flex">
                                <div class="instructor-inner">

                                    <h4 class="#">{{$user_country->name}} </h4>
                                    <p class="p-0 m-0">{{$user_timezone->timezone}}
                                        <a class="theme-rose tz-modal" href="javascript:void(0)"> Edit</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="settings-widget">
                                <div class="settings-inner-blk p-0">
                                    <div class="sell-course-head comman-space">
                                        <h3>Upcoming Lessons</h3>
                                    </div>
                                    <div class="comman-space pb-0 pt-0">
                                        <div class="settings-tickets-blk course-instruct-blk table-responsive">
                                        @if(count($upcommit)>0)
                                            <table class="table table-nowrap mb-2">
                                                <tbody>
                                                    @foreach($upcommit as $key => $val)
                                                    @php 
                                                        $user =\App\Models\User::where('id',$val->student_id)->first();
                                                    @endphp
                                                    @if($user != null && $user->StudentDetail != null)
                                                    <tr>
                                                        @php 
                                                            $class = DB::table('book_sessions')->where('id',$val->id)->first();
                                                            $t1 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                                                            $t1->setTimezone(new \DateTimeZone($user_timezone->timezone));
                                                            $times = $t1->format("Y-m-d h:i A");
                                                            $showT = $t1->format("d.m.Y - h:i A");

                                                        @endphp
                                                        <td class=" @if(isset($class) && $class->is_cancelled == 1) @else row-action @endif" data-url="{{ $val->teacher_url }}">
                                                            <div class="sell-table-group d-flex align-items-center">
                                                                <div class="sell-group-img">
                                                                    <a href="#">
                                                                        @php
                                                                        $findStudentdetails = $user->StudentDetail;
                                                                        //DB::table('student_details')->where('user_id',$val->student_id)->first();
                                                                        @endphp
                                                                        @if($findStudentdetails!=null &&
                                                                        $findStudentdetails->avtar!=null &&
                                                                        File::exists(public_path('uploads/user/avatar/'.$findStudentdetails->avtar)))
                                                                        <img src="{{asset('uploads/user/avatar/'.$findStudentdetails->avtar)}}"
                                                                            class="img-fluid " alt="">
                                                                        @else
                                                                        <img src="{{ asset('assets/img/user/user.png') }}"
                                                                            class="img-fluid " alt="">
                                                                        @endif
                                                                        {{-- <img src="{{ asset('assets/img/course/course-10.jpg') }}"
                                                                        class="img-fluid " alt=""> --}}
                                                                    </a>
                                                                </div>
                                                                <div class="sell-tabel-info">
                                                                    <p><a href="#">{{ $user->name }}</a></p>
                                                                    {{-- <div class="rating-img d-flex align-items-center">
                                                                                <p class="m-0 light-g">Lesson ID: 9874563215</p>
                                                                            </div> --}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class=" @if(isset($class) && $class->is_cancelled == 1) @else row-action @endif" data-url="{{ $val->teacher_url }}">
                                                            <div class="sell-tabel-info">
                                                                <p class="m-0">
                                                                    {{ $showT }}
                                                                </p>
                                                                {{-- <p class="m-0"><a
                                                                        href="#">{{ ($val->Classis!=null && $val->Classis->totle_class!=null)?$val->Classis->totle_class.'x Classis':'' }}</a>
                                                                </p>
                                                                <div class="rating-img d-flex align-items-center">
                                                                    <p class="m-0 light-g">
                                                                        {{ ($val->Classis!=null && $val->Classis->time!=null)?$val->Classis->time:'00' }}
                                                                        min</p>
                                                                </div> --}}
                                                            </div>
                                                        </td>
                                                        
                                                        @if(isset($class))
                                                            @if($class->is_cancelled == 1)
                                                            <td colspan="2">
                                                                <div class="sell-tabel-info text-center">
                                                                    <a  class="btn btn-danger">Cancelled</a>
                                                                </div>
                                                            </td>
                                                            @else
                                                            <td class="row-action" data-url="{{ $val->teacher_url }}">
                                                                <div class="sell-tabel-info text-center" id="count-{{ $key }}_parent">
                                                                    <p class="m-0"><a href="#">Your lesson will start in</a>
                                                                    </p>
                                                                    <div 
                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                        <p class="m-0 countdown-text-ds"  data-tm="{{ $times }}" id="count-{{ $key }}"></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        <td id="count-{{ $key }}_parent_btn">
                                                            <a href="javascript:void(0)" class="btn btn-danger cancle1" data-id="{{$val->id}}">Cancel class</a>
                                                        </td>
                                                        @endif
                                                    @endif
                                                    </tr>
                                                    <script>
                                                    // Set the date we're counting down to
                                                    var countDownDate_{{$key}} = new Date("{{ $times }}").getTime();

                                                    // Update the count down every 1 second
                                                    var x_{{$key}} = setInterval(function() {
                                                        var field = 'count-{{ $key }}';

                                                        var now = new Date(new Date().toLocaleString('en', {
                                                            timeZone: '{{ $user_timezone->timezone }}'
                                                        })).getTime();

                                                        var distance = countDownDate_{{$key}} - now;

                                                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                        var hours = Math.floor((distance % (1000 * 60 * 60 *
                                                            24)) / (1000 * 60 * 60));
                                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) /
                                                            (1000 * 60));
                                                        var seconds = Math.floor((distance % (1000 * 60)) /
                                                            1000);

                                                        var ttl = '';
                                                        if (days > 0) {
                                                            ttl += days + "d ";
                                                        }
                                                        if (hours > 0) {
                                                            ttl += hours + "h ";
                                                        }
                                                        if (minutes > 0) {
                                                            ttl += minutes + "m ";
                                                        }
                                                        if (seconds > 0) {
                                                            ttl += seconds + "s ";
                                                        }

                                                        document.getElementById(field).innerHTML = ttl;
                                                        // document.getElementById(field).innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                                                        if (distance < 0) {
                                                            clearInterval(x_{{$key}});
                                                            document.getElementById(field+'_parent').innerHTML = '<a href="{{ $val->teacher_url }}" target="_blank">Your class is live</a>';
                                                        }

                                                        if(days<=0 && hours<=0 && minutes<=10)
                                                        {
                                                            document.getElementById(field+'_parent_btn').innerHTML = '<a class="btn btn-primary" href="{{ $val->teacher_url }}" target="_blank">Join Class</a>'
                                                        }
                                                    }, 1000);
                                                    </script>
                                                    @endif
                                                    @endforeach
                                                    {{-- <tr>
                                                            <td>
                                                                <div
                                                                    class="sell-table-group d-flex align-items-center">
                                                                    <div class="sell-group-img">
                                                                        <a href="#">
                                                                            <img src="{{ asset('assets/img/course/course-10.jpg') }}"
                                                            class="img-fluid " alt="">
                                                            </a>
                                                            </div>
                                                            <div class="sell-tabel-info">
                                                                <p><a href="#">Henning Gustavsen</a></p>
                                                                <div class="rating-img d-flex align-items-center">
                                                                    <p class="m-0 light-g">Lesson ID: 9874563215</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </td>
                                                        <td>
                                                            <div class="sell-tabel-info">
                                                                <p class="m-0"><a href="#">Slide Through! B1 - B2 Kurs</a></p>
                                                                <div class="rating-img d-flex align-items-center">
                                                                    <p class="m-0 light-g">German - 60 min</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="sell-tabel-info text-center">
                                                                <p class="m-0"><a href="#">Your lesson will start in</a></p>
                                                                <div class="rating-img justify-content-center d-flex align-items-center">
                                                                    <p class="m-0 countdown-text-ds">16h 29m 08s</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="sell-table-group d-flex align-items-center">
                                                                    <div class="sell-group-img">
                                                                        <a href="#">
                                                                            <img src="{{ asset('assets/img/course/course-10.jpg') }}"
                                                                                class="img-fluid " alt="">
                                                                        </a>
                                                                    </div>
                                                                    <div class="sell-tabel-info">
                                                                        <p><a href="#">Henning Gustavsen</a></p>
                                                                        <div class="rating-img d-flex align-items-center">
                                                                            <p class="m-0 light-g">Lesson ID: 9874563215</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="sell-tabel-info">
                                                                    <p class="m-0"><a href="#">Slide Through! B1 - B2 Kurs</a></p>
                                                                    <div class="rating-img d-flex align-items-center">
                                                                        <p class="m-0 light-g">German - 60 min</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="sell-tabel-info text-center">
                                                                    <p class="m-0"><a href="#">Your lesson will start in</a></p>
                                                                    <div
                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                        <p class="m-0 countdown-text-ds">16h 29m 08s</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr> --}}
                                                    </tbody>
                                            </table>
                                        @else
                                            <div class="no_order_div py-5 text-center">
                                                <svg style="max-width: 50px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                                <h4  class="fs-4 pt-3 mb-2 fw-bold">No lesson found</h4>
                                                <p class="text-black-50">We could not find any lessons.</p>
                                            </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card instructor-card">
                    <div class="card-header">
                        <h4>Statistics</h4>
                    </div>
                    <div class="card-body">
                        <div id="ds-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>

<!-- modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="height:365px;">
            <div class="modal-header">
                <h4 class="fw-bold">Select Country And TimeZone</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('teacher.timezone.update') }}" method="POST" id="createFrm">
                    @csrf
                    <div class="container">
                        <label class="fw-bold">Country</label>
                        <select class="form-select country" aria-label="Default select example" name="country"
                            id="country_id">
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
                        <select class="form-select" aria-label="Default select example" name="timezone"
                            id="timezone_id">

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

@endsection
@push('script')
<script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
    <script>

$(document).ready(function() {
        $('.pre-loader').hide();
    });
    $(document).on('click','.cancle1',function(){
        var active = $(this).attr('data-id');
        Swal.fire({
                title: 'Do you want to cancel the class?',
                icon: 'info',
                html:
                '<a href="{{url('/student/cancle')}}" target="_blank">Cancellation Policy</a> ',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('.pre-loader').show();
                    $.ajax({
                        url: "{{ route('teacher.cancleclass') }}",
                        type: "get",
                        data: {
                            'active': active,
                        },
                        success: function(response) {
                                window.location = "{{ url('/')}}"+"/teacher/dashboard";
                            $('.pre-loader').hide();
                        }
                    });
                }
                })
        });

        var options = {
            series: [{
                name: 'Total Available Slots',
                data: @json($chart_t) //[80,70 ,42 ,51, 31, 40, 28]
            }, {
                name: 'Booked Slots',
                data: @json($chart_b) //[41, 52, 45, 34, 32, 20, 32  ]
            }],
            chart: {
                height: 300,
                type: 'area',
				toolbar: {
					show: false
				}
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
			colors: ['#4c52e1', '#f6697b'],
            xaxis: {
                type: 'datetime',
                categories: @json($chart_c) /*["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                    "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                    "2018-09-20T06:30:00.000Z"
                ]*/
            },
            tooltip: {
                x: {
                    format: 'yyyy/MM/dd'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#ds-chart"), options);
        chart.render();


    </script>

<script>
var check = "{{ Auth::user()->load('TeacherSetting')->TeacherSetting }}";
if (check == '') {
    $(document).ready(function() {
        $("#exampleModalCenter").modal({
            show: false,
            backdrop: 'static'
        });
        $("#exampleModalCenter").modal("show");
    })
}

$(document).on('click', '.tz-modal', function() {
    $('#exampleModalCenter').modal('show');
});

$(document).on('change', '.country', function() {
    var id = $('#country_id').val();
    $.ajax({
        type: "post",
        url: "{{route('timezone-list')}}",
        data: {
            'country_id': id,
            "_token": "{{ csrf_token() }}"
        },
        success: function(data) {
            $("#timezone_id").empty();
            $("#timezone_id").html('<option value="">Select Timezone</option>');
            $.each(data, function(key, value) {
                $("#timezone_id").append('<option value="' + value.id + '">' + value
                    .timezone + '</option>');
            });
            $('#tiz').removeClass('d-none');
        }
    });
});
//submit
$(document).on('change', '.country', function() {
    var id = $('#country_id').val();
    $.ajax({
        type: "post",
        url: "{{route('timezone-list')}}",
        data: {
            'country_id': id,
            "_token": "{{ csrf_token() }}"
        },
        success: function(data) {
            $("#timezone_id").empty();
            $("#timezone_id").html('<option value="">Select Timezone</option>');
            $.each(data, function(key, value) {
                $("#timezone_id").append('<option value="' + value.id + '">' + value
                    .timezone + '</option>');
            });
        }
    });
});

$(document).on('submit', 'form#createFrm', function(event) {
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
                $('.submit').html('Save');
            }, 2000);
            //console.log(response);
            if (response.success == true) {
                //notify
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'TimeZone Updated Successfully',
                //     showConfirmButton: false,
                //     timer: 1500
                //     })
                // $('body').append('<div class="alert alert-success my-toast"><p>Timezone updated succeswsfully</p></div>').fadeIn(2000);
                $('<div class="alert alert-success my-toast"><p>Timezone updated successfully</p></div>')
                    .hide().appendTo("body").fadeIn(800);
                window.setTimeout(function() {
                    location.reload();
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

$(document).on('click', '.row-action', function() {
    window.open($(this).data('url'), '_blank');
});
</script>
@endpush

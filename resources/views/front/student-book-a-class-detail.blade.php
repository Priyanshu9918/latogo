@extends('layouts.student.master')
@section('content')
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.ie11.min.js"></script>
<style>
      .sec-slot {
        background: red !important;
    }
    .mw-80 {
        max-width: 80px;
    }
    #lessons-rules .modal-dialog{
        max-width:70%;
    }
    @media (max-width: 600px) {
        #lessons-rules .modal-dialog{
            max-width:100%;
        }
        .toastui-calendar-timegrid-time-column{
            width: 40px !important;
        }
        .toastui-calendar-columns{
            left: 40px !important;
        }
        .toastui-calendar-day-name-container{
            margin-left: 40px!important;
        }
        .sell-group-img {
            width: 50px;
            margin-right: 0px;
        }
        .sell-group-img img {
            width: 40px;
            border-radius: 50px;
            height: 40px;}
    }
    .student-ticket-view {
        width: 70%;
    }

    .mw-80-text-center {
        max-width: 80%;
        text-align: center;
        display: block;
        margin: auto;
    }

    .toastui-calendar-timegrid-time-column {
        font-size: 11px;
        /* height: 100%; */
    }

    /* .toastui-calendar-panel.toastui-calendar-time
    {
        height: 100% !important;
    } */
    .toastui-calendar-timegrid .toastui-calendar-timegrid-scroll-area {
        position: unset !important;
    }

    .toastui-calendar-day-names.toastui-calendar-week {
        height: 45px;
    }
    .student-ticket-view {
        width: 70%;
    }

    /*=======*/
    :root {
  --star-size: 60px;
  --star-color: #777;
  --star-background: #fc0;
}
.average-rating span {
    color: #ffb54a;
    font-size: 20px;
}

.Stars {
  --percent: calc(var(--rating) / 5 * 100%);

  display: inline-block;
  font-size: 34px;
  font-family: Times;
  line-height: 1;

  &::before {
    content: '★★★★★';
    letter-spacing: -2px;
    background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
}
</style>
<script>
    var calendar = '';
</script>
<div class="course-student-header d-none">
    <div class="container">
        <div class="student-group">
            <div class="course-group ">
                <div class="course-group-img d-flex">
                    <a href="#"><img src="{{ asset('assets/img/user/user11.jpg') }}" alt="" class="img-fluid"></a>
                    <div class="d-flex align-items-center">
                        <div class="course-name">
                            <h4><a href="#">Rolands R</a><span>Beginner</span></h4>
                            <p>Student</p>
                        </div>
                    </div>
                </div>
                <div class="course-share ">
                    <a href="javascript:;" class="btn btn-primary">Account Settings</a>
                </div>
            </div>
        </div>
        <div class="my-student-list">
            <ul>
                <li><a class="active" href="#">Dashboard</a></li>
                <li><a href="#">Courses</a></li>
                <li><a href="#">Wishlists</a></li>
                <li><a href="#">Messages</a></li>
                <li><a href="#">Purchase history</a></li>
                <li><a href="#">Deposit</a></li>
                <li class="mb-0"><a href="#">Transactions</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="">
    <section class="page-content course-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card overview-sec">
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="instructor-wrap border-bottom-0 mb-0">
                                    <div class="about-instructor align-items-baseline">
                                        @php
                                        $findTeacherdetails = Helper::findTeacherdetails($class->teacher_id);
                                        @endphp
                                        @if($findTeacherdetails!=null && $findTeacherdetails->avatar)
                                        <div class="abt-instructor-img">
                                            <a href="#">
                                                <img src="{{ url('uploads/user/avatar/'.$findTeacherdetails->avatar) }}" alt="img" class="img-fluid">
                                            </a>
                                        </div>
                                        @else
                                        <div class="abt-instructor-img">
                                            <a href="#">
                                                <img src="{{ asset('/assets/img/user/user.png') }}" alt="img" class="img-fluid">
                                            </a>
                                        </div>
                                        @endif
                                        <div class="instructor-detail me-3">
                                            @php
                                            $findTeacherName = Helper::findTeacherName($class->teacher_id);
                                            @endphp
                                            <h2 class="m-0">{{ $findTeacherName?$findTeacherName->name:'--' }}</h2>
                                            <p>Professional Teacher</p>
                                            <div class="course-info border-bottom-0 mb-0 pb-0">
                                                <div class="cou-info">
                                                    <img src="{{ asset('assets/img/icon/icon-01.svg') }}" alt="">
                                                    <p><b>Teaches</b> :{{ $class->teaches }} </p>
                                                </div>
                                                <div class="cou-info">
                                                    <img style="width: 24px;" src="{{ asset('assets/img/speaking-head.png') }}" alt="">
                                                    @php
                                                    $findTeacherdetails = Helper::findTeacherdetails($class->teacher_id);
                                                    $lang_data = ($findTeacherdetails!=null && $findTeacherdetails->language!=null)?json_decode($findTeacherdetails->language):array();
                                                    @endphp
                                                    <p><b>Speaks</b> :
                                                        <?php
                                                        for ($i = 0; $i < count($lang_data); $i++) {
                                                            $lang_name = DB::table("language_masters")->where('id', $lang_data[$i])->first();
                                                            $lang_name = $lang_name->language;
                                                            if (!$i == 0) {
                                                                echo ", ";
                                                            }
                                                            echo  $lang_name;
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="subs-title mt-4">Overview</h5>
                            <p>{!! $findTeacherdetails->about_me??'' !!}</p>
                            <h6>Me as a teacher </h6>
                            <div class="row">
                                <p>{!! $findTeacherdetails->me_as_teacher??'' !!}</p>
                            </div>
                            <h6>My lessons and teaching style</h6>
                            <p>{!! $findTeacherdetails->my_teaching_style??'' !!}</p>
                        </div>
                    </div>
                    @php
                    $getReview = Helper::getReview($class->teacher_id);
                    $re_count = count($getReview);

                    @endphp
                    @if(isset($re_count) && $re_count != 0)
                    <h5 class="subs-title">Reviews</h5>
                    <div class="row">

                        @foreach($getReview as $find)
                        <div class="col-md-6">
                            <div class="card review-sec ">
                                <div class="card-body">
                                    <div class="cardds">
                                        <div class="instructor-wrap">
                                            <div class="about-instructor">
                                                <?php $img =  DB::table('teacher_settings')->where('user_id', $class->teacher_id)->first(); ?>
                                                @if($img->avatar)
                                                <div class="abt-instructor-img">
                                                    <a href="#"><img src="{{ url('uploads/user/avatar/'.$img->avatar) }}" alt="img" class="img-fluid"></a>
                                                </div>
                                                @else
                                                <div class="abt-instructor-img">
                                                    <a href="#"><img src="{{ asset('/assets/img/user/user.png') }}" alt="img" class="img-fluid"></a>
                                                </div>
                                                @endif
                                                <div class="instructor-detail">
                                                    <h5><a href="#">{{ $find->title }}</a></h5>

                                                </div>
                                            </div>
                                        </div>
                                        <p class="rev-info m-0">{{ $find->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    @php
                    $findTeacherdetails = Helper::findTeacherdetails($class->teacher_id);
                    @endphp
                    <div class="">
                        <div class="video-sec vid-bg">
                            <div class="card">
                                <div class="card-body">
                                    @if($findTeacherdetails!=null && $findTeacherdetails->youtube_link)
                                    <iframe width="100%" height="200" src="{{ $findTeacherdetails->youtube_link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    @else
                                    <iframe width="100%" height="200" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    @endif
                                    <div class="video-details">
                                        <div class="course-fee">
                                        </div>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#lessons-rules" class="btn  btn-filled btn-enroll w-100">Book a lesson</a>
                                        <div class="col-md-12">
                                            @php
                                            $findTeacherName = Helper::findTeacherName($class->teacher_id);
                                            @endphp
                                            <a href="{{ url('chatify/'.$class->teacher_id) }}" class="btn btn-wish w-100 mt-3">Contact Teacher</a>
                                            <!-- <a href="{{ route('student.messages') }}?user={{ $class->teacher_id }}" class="btn btn-wish w-100 mt-3">Contact Teacher</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card include-sec d-none">
                            <div class="card-body">
                                <div class="cat-title">
                                    <h4>Includes</h4>
                                </div>
                                <ul>
                                    <li><img src="assets/img/icon/import.svg" class="me-2" alt=""> 11 hours
                                        on-demand video</li>
                                    <li><img src="assets/img/icon/play.svg" class="me-2" alt=""> 69 downloadable
                                        resources</li>
                                    <li><img src="assets/img/icon/key.svg" class="me-2" alt=""> Full lifetime
                                        access</li>
                                    <li><img src="assets/img/icon/mobile.svg" class="me-2" alt=""> Access on
                                        mobile and TV</li>
                                    <li><img src="assets/img/icon/cloud.svg" class="me-2" alt=""> Assignments
                                    </li>
                                    <li><img src="assets/img/icon/teacher.svg" class="me-2" alt=""> Certificate
                                        of Completion</li>
                                </ul>
                            </div>
                        </div>
                        <div class="card feature-sec">
                            <div class="card-body">
                                <div class="cat-title">
                                    <h4>Includes</h4>
                                </div>
                                <ul>
                                @if($class->rating/2 != 0)
                                    <li class="d-flex align-items-center">
                                        <span><img src="assets/img/icon/users.svg" class="me-2" alt="">
                                            Rating:
                                        </span>
                                        <span>
                                            <div class="rating m-0">
                                            <div class="Stars" style="--rating: {{$class->rating/2}};" aria-label="Rating of this product is 2.3 out of 5."></div>
                                                <span class="d-inline-block average-rating"><span>{{$class->rating/2 ?? ''}} </span></span>
                                            </div>
                                        </span>
                                    </li>
                                @endif
                                    <li><img src="assets/img/icon/timer.svg" class="me-2" alt=""> Students:
                                        <span>{{ $class->student_count }}</span>
                                    </li>
                                    <li><img src="assets/img/icon/chapter.svg" class="me-2" alt=""> Lessons:
                                        <span>{{ $class->lessons }}</span>
                                    </li>
                                    <li><img src="assets/img/icon/chart.svg" class="me-2" alt=""> Success :
                                        {{ $class->success }}%<span>
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<!-- <script src="assets/js/jquery-3.6.0.min.js"></script> -->
<!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>
<!-- Modal -->
<div class="modal fade" id="lessons-rules" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content selectplan">
            <div class="modal-header">
                <span><i class="fa-solid fa-chevron-left"></i></span>
                <h1 class="modal-title fs-5" id="exampleModalLabel">Lesson Options</h1>
                <button type="button" class="btn-close m-0 p-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="container">
                    {{-- <div class="headline-sec-pop text-center py-4">
                        <h3>Lessons rules</h3>
                        <p class="text-black-50 mw-80-text-center">In elit dolor, placerat ac nisl ut, convallis
                            fringilla augue. Cras at porttitor lectus. Duis auctor turpis vel dolor maximus
                            molestie. Curabitur sed arcu eget diam condimentum rhoncus id vel tellus.</p>
                    </div> --}}
                    <div class="row py-5">
                        @if(count($user->Credit)>0)
                            @php $c_count = 0; @endphp
                            @foreach($user->Credit as $cr)
                                @if($cr->credit>0)
                                    <div class="col-md-3">
                                        <div class="content choose-plan text-center">
                                            <h4>{{ $cr->Classis->time }} min</h4>
                                            <i class="fa-solid fa-chevron-down"></i>
                                            <label class="d-flex box justify-content-between" for="">
                                                <!-- <p class="m-0">{{ $class->lessons }} Lesson</p> -->
                                                <p class="m-0">Lesson</p>
                                                <p class="m-0">$ {{ $cr->Classis->price }}</p>
                                                <input type="radio" class="d-none c-btn" name="class" value="{{ $cr->Classis->id }}" />
                                            </label>
                                            <sup>{{ ($cr->Classis->MasterClass!=null)?$cr->Classis->MasterClass->title:'' }}</sup>
                                        </div>
                                    </div>
                                    @php $c_count++; @endphp
                                @endif
                            @endforeach

                            @if($c_count==0)
                                <div class="container text-center">
                                    Attention! You are out of credits.<br>Click below to purchase more classes and continue mastering the German language! 
                                    <div class="row mt-5">
                                        <div class="offset-3 col-6">
                                            <a class="btn btn-primary" href="{{ route('view') }}">Get more credits</a>
                                        </div>
        
                                    </div>
                                </div>
                            @endif

                        @else
                        <div class="container text-center">
                            Attention! You are out of credits.<br>Click below to purchase more classes and continue mastering the German language! 
                            <div class="row mt-5">
                                <div class="offset-3 col-6">
                                    <a class="btn btn-primary" href="{{ route('view') }}">Get more credits</a>
                                </div>

                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if(count($user->Credit)>0) <button type="button" class="btn btn-primary find_slot">Next</button> @endif
                {{-- data-bs-toggle="modal" data-bs-target="#schedule-calendar" --}}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="schedule-calendar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        {{-- style="max-width:70%;" --}}
        <div class="modal-content selectplan">
            <div class="modal-header">
                <span><i class="fa-solid fa-chevron-left"></i></span>
                <h1 class="modal-title fs-5">Select the time slots in green that work best for you and head over to <b>"Book Now"</b></h1>
                <button type="button" class="btn-close m-0 p-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body time-frame">
                {{-- <div class="container">
                    <button class="btn btn-primary btn-prev"> prev</button>
                    <button class="btn btn-primary btn-today">Today</button>
                    <button class="btn btn-primary btn-nxt"> nxt</button>
                    <div id="container" style="height: 600px;"></div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-session">Book now</button>
            </div>
        </div>
    </div>
</div>
<form action="" method="" class="d-none" id="boking_form">
    <input type="hidden" id="class_id" name="class_id" value="">
    <input type="hidden" id="t_credit" name="t_credit" value="">
    <input type="hidden" id="teacher_id" name="teacher_id" value="{{ $class->teacher_id }}">
    <input type="hidden" id="student_id" name="student_id" value="{{ auth()->user()->id }}">
    <input type="hidden" id="date_time" name="date_time" value="">
    <input type="hidden" id="class_quee" name="class_quee" value="">

</form>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     var calendarEl = document.getElementById('calendarweek');

    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         timeZone: 'UTC',
    //         initialView: 'timeGridWeek',
    //         headerToolbar: {
    //             left: 'prev,next today',
    //             center: 'title',
    //             right: 'timeGridWeek,timeGridDay'
    //         },
    //         events: 'https://fullcalendar.io/api/demo-feeds/events.json'
    //     });

    //     calendar.render();
    // });
    $(document).on("click", ".choose-plan .box", function() {
        $('.choose-plan .box').removeClass('active');
        $(this).addClass('active');
        var id = $(this).find('input').val();
        $('#class_id').val(id);
    });

    $(document).on("click", ".find_slot", function() {
        var c_id = $('#class_id').val();
        var t_id = $('#teacher_id').val();
        if (c_id == '') {
            alert('Please select at least 1 lession rule');
        } else {
            $.ajax({
                url: "{{ route('cal') }}",
                type: 'GET',
                data: {
                    c_id: c_id,
                    t_id: t_id
                },
                dataType: 'json',
                success: function(data) {
                    $("#t_credit").val(data.credit);
                    $('.time-frame').html(data.html);
                    $('#schedule-calendar').modal('show');

                    setTimeout(() => {
                        cal_init();
                    }, 800);
                }
            });
        }
    });
</script>

@endpush

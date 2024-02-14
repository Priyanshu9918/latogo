@extends('layouts.student.master3')
@section('content')
        <style>
    .mw-80 {
        max-width: 80px;
    }

    .student-ticket-view {
        width: 70%;
    }

    .settings-top-widget .stat-info h3 {
        font-size: 19px;
        font-weight: 600;
        line-height: 30px;
        margin: 16px 0;
        color: #000 !important;
        letter-spacing: -0.1px;
    }

    .settings-inner-blk li.nav-item span.active h3 {
        color: #392c7d !important;
    }

    h3.gaycolor-ds {
        color: #74747485;
    }

    /*===================================*/
    :root {
        --dark-body: #4D4C5A;
        --dark-main: #141529;
        --dark-second: #79788C;
        --dark-hover: #323048;
        --dark-text: #F8FBFF;

        --light-body: #F3F8FE;
        --light-main: #FDFDFD;
        --light-second: #C3C2C8;
        --light-hover: #EDF0F5;
        --light-text: #151426;

        --green: #03C988;
        --white: #fff;

        --shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

        --font-family: cursive;
    }

    .dark {
        --bg-body: var(--dark-body);
        --bg-main: var(--dark-main);
        --bg-second: var(--dark-second);
        --color-hover: var(--dark-hover);
        --color-txt: var(--dark-text);
    }

    .light {
        --bg-body: var(--light-body);
        --bg-main: var(--light-main);
        --bg-second: var(--light-second);
        --color-hover: var(--light-hover);
        --color-txt: var(--light-text);
    }


    .calendar {
        height: max-content;
        width: max-content;
        /* background-color: var(--bg-main); */
        border-radius: 30px;
        position: relative;
        overflow: hidden;
    }

    .light .calendar {
        /* box-shadow: var(--shadow); */
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 25px;
        font-weight: 600;
        color: var(--color-txt);
        /* padding: 10px; */
    }

    .calendar-body {
        padding: 10px;
    }

    .calendar-week-day {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        font-weight: 600;
        height: 50px;
    }

    .calendar-week-day div {
        display: grid;
        place-items: center;
        color: var(--bg-second);
    }

    .calendar-day {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        color: var(--color-txt);
    }

    .calendar-day div {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        position: relative;
        cursor: pointer;
        animation: to-top 1s forwards;
    }

    .month-picker {
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
    }

    .month-picker:hover {
        background-color: var(--color-hover);
    }

    .year-picker {
        display: flex;
        align-items: center;
    }

    .year-change {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        cursor: pointer;
    }

    .year-change:hover {
        background-color: var(--color-hover);
    }

    .calendar-footer {
        padding: 10px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .toggle {
        display: flex;
    }

    .toggle span {
        margin-right: 10px;
        color: var(--color-txt);
    }

    .dark-mode-switch {
        position: relative;
        width: 48px;
        height: 25px;
        border-radius: 14px;
        background-color: var(--bg-second);
        cursor: pointer;
    }

    .dark-mode-switch-ident {
        width: 21px;
        height: 21px;
        border-radius: 50%;
        background-color: var(--bg-main);
        position: absolute;
        top: 2px;
        left: 2px;
        transition: left 0.2 ease-in-out;
    }

    .dark .dark-mode-switch .dark-mode-switch-ident {
        top: 2px;
        left: calc(2px + 50%);
    }

    .calendar-day div span {
        position: absolute;
    }

    .calendar-day div:hover span {
        transition: width 0.2s ease-in-out, height 0.2s ease-in-out;
    }

    .calendar-day div span:nth-child(1),
    .calendar-day div span:nth-child(3) {
        width: 2px;
        height: 0;
        background-color: var(--color-txt);
    }

    .calendar-day div:hover span:nth-child(1),
    .calendar-day div:hover span:nth-child(3) {
        height: 100%;
    }

    .calendar-day div span:nth-child(1) {
        bottom: 0;
        left: 0;
    }

    .calendar-day div span:nth-child(3) {
        top: 0;
        right: 0;
    }

    .calendar-day div span:nth-child(2),
    .calendar-day div span:nth-child(4) {
        width: 0;
        height: 2px;
        background-color: var(--color-txt);
    }

    .calendar-day div:hover span:nth-child(2),
    .calendar-day div:hover span:nth-child(4) {
        width: 100%;
    }

    .calendar-day div span:nth-child(2) {
        top: 0;
        left: 0;
    }

    .calendar-day div span:nth-child(4) {
        bottom: 0;
        right: 0;
    }

    .calendar-day div:hover span:nth-child(2) {
        transition-delay: 0.2s;
    }

    .calendar-day div:hover span:nth-child(3) {
        transition-delay: 0.4s;
    }

    .calendar-day div:hover span:nth-child(4) {
        transition-delay: 0.6s;
    }

    .calendar-day div.currDate {
        background-color: var(--green);
        color: var(--white);
        border-radius: 50%;
    }

    .calendar-day div.currDate span {
        display: none;
    }

    .month-list {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: var(--bg-main);
        padding: 20px;
        color: var(--color-txt);
        display: grid;
        grid-template-columns: repeat(3, auto);
        gap: 5px;
        transform: scale(1.5);
        visibility: hidden;
        pointer-events: none;
    }

    .month-list.show {
        transform: scale(1);
        visibility: visible;
        pointer-events: visible;
        transition: all 0.2s ease-in-out;
    }

    .month-list>div {
        display: grid;
        place-items: center;
    }

    .month-list>div>div {
        width: 100%;
        padding: 5px 20px;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
    }

    .month-list>div>div:hover {
        background-color: var(--color-hover);
    }

    @keyframes to-top {
        0% {
            transform: translateY(100%);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
    .today{
        border: 5px solid var(--green);
    }
    .day-dis {
        color: gray;
    }
    span#month-picker::before {
        content: "< ";
    }
    span#month-picker::after {
        content: " >";
    }
    @media (max-width: 600px) {
 
        .sell-group-img {
            width: 50px;
            margin-right: 10px;
        }
        .sell-group-img img {
            width: 40px;
            border-radius: 50px;
            height: 40px;
            max-width: 100% !important;
            min-width: 100% !important;} 
    }
    </style>


<div class="pre-loader" style="display: block;"></div>
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

							<div class="col-md-3 d-flex">
                                <div class="card instructor-card w-100">

                                    <div class="card-body align-items-center justify-content-center d-flex">
										<div>
                                        @php
                                            $user_id = Auth::user()->id;
                                            $student1 = DB::table('student_details')->where('user_id',$user_id)->first();
                                        @endphp
                                        @if(isset($student1->avtar))
                                            <a><img class="avtar-style" src="{{asset('uploads/user/avatar/'.$student1->avtar)}}" alt=""
                                            ></a>
                                        @else
                                        <img class="avtar-style" src="{{asset('assets/img/user/user.png')}}" alt="" >
                                        @endif

										</div>
                                        <div class="instructor-inner">
                                            <h4  class="fs-18">{{Auth::user()->name;}}</h4>
                                            @php
                                            $user_id = Auth::user()->id;
                                            $user1 = DB::table('student_details')->where('user_id',$user_id)->first();
                                            $timezone = DB::table('time_zones')->where('id',$user1->timezone ?? 136)->first();
                                            $tz = $timezone->timezone;
                                            $timestamp = time();
                                            $dt = new DateTime("now", new DateTimeZone($tz));
                                            $dt1 = new DateTime("now", new DateTimeZone('Europe/Berlin'));
                                            $dt->setTimestamp($timestamp);
                                            @endphp
                                            <p>User ID :{{ $user_id}}</p>
                                            @if(isset($user1))
                                                @if($user1->time_formate == 1)
                                                <p>{{$dt->format('H:i')}} (UTC {{$timezone->raw_offset}}.00)</p>
                                                @endif
                                                @if($user1->time_formate == 0)
                                                <p>{{$dt->format('h:ia')}} (UTC {{$timezone->raw_offset}}.00)</p>
                                                @endif
                                            @else
                                                <p>{{$dt1->format('h:ia')}} (UTC {{$timezone->raw_offset}}.00)</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 d-flex">
                                <div class="card instructor-card w-100">
                                    <div class="card-body text-center align-items-center justify-content-center d-flex">
                                        <div class="instructor-inner">
                                            <h4 class="#">{{ count($upcommit1) }}</h4>
                                            <p>Upcoming Lessons</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 d-flex">
                                <div class="card instructor-card w-100">
                                    <div class="card-body text-center align-items-center justify-content-center d-flex">
                                        <div class="instructor-inner">
                                            <?php
                                            $Purchased = DB::table('orders')->where('user_id', $user_id)->where('is_completed',1)->get()->count();
                                            ?>
                                            <a href="{{ url('student/student-my-order') }}" ><h4 class="">{{ $Purchased }}</h4></a>
                                            <p>Purchased</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 d-flex">
                                <div class="card instructor-card w-100">
                                    <div class="card-body text-center align-items-center justify-content-center d-flex">
                                        <div class="instructor-inner">
                                            @php
                                            $user = Auth::user()->id;
                                            $Purchased = DB::table('credits')->where('user_id', $user_id)->get();
                                            $sum = 0;
                                            foreach($Purchased as $data)
                                            {
                                                $val = DB::table('credits')->where('id', $data->id)->value('credit');
                                                $sum = $sum + $val;
                                            }
                                            @endphp
                                            <h4 class="#">{{$sum}}</h4>
                                            <p>Remaining credits</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 d-flex">
                                <div class="card instructor-card w-100">
                                    <div class="card-body text-center align-items-center justify-content-center d-flex">
                                        <div class="instructor-inner">
                                            @php
                                                $user_id = Auth::user()->id;
                                                $user = DB::table('student_details')->where('user_id',$user_id)->first();
                                                $country1 = DB::table('countries')->where('id',$user->country ?? 82)->first();
                                                $timezone1 = DB::table('time_zones')->where('id',$user->timezone ?? 136)->first();
                                            @endphp
                                            <h4 class="#">{{$country1->name ?? ''}} </h4>
                                            <p class="p-0 m-0">{{$timezone1->timezone ?? ''}}<a class="theme-rose" href="javascript:void(0)" onclick="TimeZone()"> Edit</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="settings-widget">
                                            <div class="settings-inner-blk p-0">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item" role="">
                                                        <span class="active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"  role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                                            <div class="sell-course-head comman-space">
                                                                <h3 class="gaycolor-ds">Upcoming Classes</h3>
                                                            </div>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item" role="">
                                                        <span class="" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"  role="tab"
                                                            aria-controls="profile-tab-pane" aria-selected="false">
                                                            <div class="sell-course-head comman-space">
                                                                <h3 class="gaycolor-ds">Past Classes</h3>
                                                            </div>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="home-tab-pane"
                                                        role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                                        <div class="comman-space pb-0 pt-0">
                                                            <div
                                                                class="settings-tickets-blk course-instruct-blk table-responsive uc-table">
                                                                @if(count($upcommit)>0)
                                                                <table class="table table-nowrap mb-2">
                                                                    <tbody>
                                                                        @foreach($upcommit as $key => $val)
                                                                        @php
                                                                            $t1 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                                                                            $t1->setTimezone(new \DateTimeZone($tz));
                                                                            $times = $t1->format("Y-m-d H:i");
                                                                            $showT = $t1->format("d.m.Y - h:i A");
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="row-action" data-url="{{ $val->student_url }}">
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            @php $findTeacherdetails = Helper::findTeacherdetails($val->teacher_id); @endphp
                                                                                            @if($findTeacherdetails!=null && $findTeacherdetails->avatar!=null && File::exists(public_path('uploads/user/avatar/'.$findTeacherdetails->avatar)))
                                                                                            <img src="{{asset('uploads/user/avatar/'.$findTeacherdetails->avatar)}}" class="img-fluid " alt="">
                                                                                            @else
                                                                                            <img src="{{ asset('assets/img/user/user.png') }}" class="img-fluid " alt="">
                                                                                            @endif
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p>
                                                                                            <a href="#">
                                                                                                @php $t_name = Helper::findTeacherName($val->teacher_id) @endphp
                                                                                                {{ ($t_name!=null && $t_name->name!=null)?$t_name->name:'-' }}
                                                                                            </a>
                                                                                        </p>
                                                                                        {{-- <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="row-action" data-url="{{ $val->student_url }}">
                                                                                <p class="m-0">
                                                                                    {{ $showT }}
                                                                                </p>
                                                                                <div class="sell-tabel-info">
                                                                                    {{-- <p class="m-0">
                                                                                        <a href="#">
                                                                                            {{ ($val->Classis!=null && $val->Classis->totle_class!=null)?$val->Classis->totle_class.'x Classes':'' }}
                                                                                        </a>
                                                                                    </p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">{{ ($val->Classis!=null && $val->Classis->time!=null)?$val->Classis->time:'00' }} min
                                                                                        </p>
                                                                                    </div> --}}
                                                                                </div>
                                                                            </td>
                                                                            @php
                                                                                $class = DB::table('book_sessions')->where('id',$val->id)->first();
                                                                            @endphp
                                                                            @if(isset($class))
                                                                                @if($class->is_cancelled == 1)
                                                                                <td>
                                                                                <div class="sell-tabel-info text-center">
                                                                                    <a  class="btn btn-danger">Cancelled</a>
                                                                                    </div>
                                                                                </td>
                                                                                @else
                                                                                <td class="row-action" data-url="{{ $val->student_url }}">
                                                                                    <div class="sell-tabel-info text-center" id="count-{{ $key }}_parent">
                                                                                        <p class="m-0"><a href="#">Your
                                                                                                lesson will
                                                                                                start in</a></p>
                                                                                        <div class="rating-img justify-content-center d-flex align-items-center">
                                                                                            <p class="m-0 countdown-text-ds" id="count-{{ $key }}" data-temp="{{ $val->con_time }}" data-tz="{{ $tz }}"></p>

                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center" id="count-{{ $key }}_parent_btn">
                                                                                    <a href="javascript:void(0)" class="btn btn-danger cancle1" data-id="{{$val->id}}">Cancel class</a>
                                                                                </td>
                                                                                @endif
                                                                            @endif
                                                                            <script>
                                                                                // Set the date we're counting down to
                                                                                var countDownDate_{{ $key }} = new Date("{{ $times }}").getTime();

                                                                                // Update the count down every 1 second
                                                                                var x_{{ $key }} = setInterval(function() {
                                                                                    var field = 'count-{{ $key }}';

                                                                                    var now = new Date(new Date().toLocaleString('en', {timeZone: '{{ $tz }}'})).getTime();
                                                                                    // console.log(countDownDate_{{ $key }} +'-'+ now);
                                                                                    var distance = countDownDate_{{ $key }} - now;

                                                                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                                                    var ttl = '';
                                                                                    if(days>0)
                                                                                    {
                                                                                        ttl += days + "d ";
                                                                                    }
                                                                                    if(hours>0)
                                                                                    {
                                                                                        ttl += hours + "h " ;
                                                                                    }
                                                                                    if(minutes>0)
                                                                                    {
                                                                                        ttl += minutes + "m " ;
                                                                                    }
                                                                                    if(seconds>0)
                                                                                    {
                                                                                        ttl += seconds + "s ";
                                                                                    }

                                                                                    document.getElementById(field).innerHTML = ttl;
                                                                                    // document.getElementById(field).innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                                                                                    

                                                                                    if (distance < 0) {
                                                                                        clearInterval(x_{{ $key }});
                                                                                        document.getElementById(field+'_parent').innerHTML = '<a href="{{ $val->student_url }}" target="_blank">Your class is live</a>';
                                                                                    }

                                                                                    if(days<=0 && hours<=0 && minutes<=10)
                                                                                    {
                                                                                        document.getElementById(field+'_parent_btn').innerHTML = '<a class="btn btn-primary" href="{{ $val->student_url }}" target="_blank">Join Class</a>'
                                                                                    }

                                                                                }, 1000);
                                                                                </script>
                                                                        </tr>
                                                                        @endforeach
                                                                        {{-- <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                                class="img-fluid "
                                                                                                alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p><a href="#">Henning
                                                                                                Gustavsen</a></p>
                                                                                        <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0"><a href="#">Slide
                                                                                            Through! B1
                                                                                            - B2 Kurs</a></p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">German -
                                                                                            60 min
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0"><a href="#">Your
                                                                                            lesson will
                                                                                            start in</a></p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                                class="img-fluid "
                                                                                                alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p><a href="#">Henning
                                                                                                Gustavsen</a></p>
                                                                                        <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0"><a href="#">Slide
                                                                                            Through! B1
                                                                                            - B2 Kurs</a></p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">German -
                                                                                            60 min
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0"><a href="#">Your
                                                                                            lesson will
                                                                                            start in</a></p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
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
                                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                                        aria-labelledby="profile-tab" tabindex="0">
                                                        <div class="comman-space pb-0 pt-0">
                                                            <div
                                                                class="settings-tickets-blk course-instruct-blk table-responsive">
                                                                @if(count($past)>0)
                                                                <table class="table table-nowrap mb-2">
                                                                    <tbody>
                                                                        @foreach ($past as $key => $val)
                                                                        @php
                                                                            $t1 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                                                                            $t1->setTimezone(new \DateTimeZone($tz));
                                                                            $times = $t1->format("Y-m-d H:i");
                                                                            $showT = $t1->format("d.m.Y - h:i A");
                                                                        @endphp
                                                                        <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            @php $findTeacherdetails = Helper::findTeacherdetails($val->teacher_id); @endphp
                                                                                            @if($findTeacherdetails!=null && $findTeacherdetails->avatar!=null && File::exists(public_path('uploads/user/avatar/'.$findTeacherdetails->avatar)))
                                                                                            <img src="{{asset('uploads/user/avatar/'.$findTeacherdetails->avatar)}}" class="img-fluid " alt="">
                                                                                            @else
                                                                                            <img src="{{ asset('assets/img/user/user.png') }}" class="img-fluid " alt="">
                                                                                            @endif
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p>
                                                                                            <a href="#">
                                                                                                @php $t_name = Helper::findTeacherName($val->teacher_id) @endphp
                                                                                                {{ ($t_name!=null && $t_name->name!=null)?$t_name->name:'-' }}
                                                                                            </a>
                                                                                        </p>
                                                                                        {{-- <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0">
                                                                                        {{ $showT }}
                                                                                    </p>
                                                                                    {{-- <p class="m-0">
                                                                                        <a href="#">
                                                                                            {{ ($val->Classis!=null && $val->Classis->totle_class!=null)?$val->Classis->totle_class.'x Classes':'' }}
                                                                                        </a>
                                                                                    </p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">{{ ($val->Classis!=null && $val->Classis->time!=null)?$val->Classis->time:'00' }} min
                                                                                        </p>
                                                                                    </div> --}}
                                                                                </div>
                                                                            </td>
                                                                            {{-- <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0">
                                                                                        <a href="#">
                                                                                            Expired
                                                                                        </a>
                                                                                    </p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td> --}}
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0">
                                                                                        <a href="{{ $val->record_url }}" target="_blank" class="btn btn-primary">
                                                                                            <i class='fas fa-file-video'></i> &nbsp; Rec. / Board.
                                                                                        </a>
                                                                                    </p>
                                                                                </div>
                                                                            </td>
                                                                            {{-- <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0">
                                                                                        @if($val->merithub_class_id!=null && $val->merithub_sub_class_id!=null)
                                                                                            <a href="https://live.merithub.com/room/whiteboard/{{ $merithub->client_id }}/{{ $val->merithub_class_id }}/{{ $val->merithub_sub_class_id }}" target="_blank" class="btn btn-primary">
                                                                                                <i class="fa fa-chalkboard-user"></i> &nbsp; Board.
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:;" class="btn btn-primary not-ready">
                                                                                                <i class="fa fa-chalkboard-user"></i> &nbsp; Board.
                                                                                            </a>
                                                                                        @endif
                                                                                    </p>
                                                                                </div>
                                                                            </td> --}}
                                                                        </tr>
                                                                        @endforeach
                                                                        {{-- <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                                class="img-fluid "
                                                                                                alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p><a href="#">Henning
                                                                                                Gustavsen</a></p>
                                                                                        <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0"><a href="#">Slide
                                                                                            Through! B1
                                                                                            - B2 Kurs</a></p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">German -
                                                                                            60 min
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0"><a href="#">Your
                                                                                            lesson will
                                                                                            start in</a></p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                                class="img-fluid "
                                                                                                alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p><a href="#">Henning
                                                                                                Gustavsen</a></p>
                                                                                        <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0"><a href="#">Slide
                                                                                            Through! B1
                                                                                            - B2 Kurs</a></p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">German -
                                                                                            60 min
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0"><a href="#">Your
                                                                                            lesson will
                                                                                            start in</a></p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
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
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="light">
                                        <div class="calendar">
                                            <!-- CALENDAR HEADER START -->
                                            <div class="calendar-header">
                                                <span class="month-picker" id="month-picker">
                                                    February
                                                </span>
                                                <div class="year-picker">
                                                    <span class="year-change " id="prev-year">
                                                        <pre class="m-0"> < </pre>
                                                    </span>
                                                    <span id="year">2023</span>
                                                    <span class="year-change " id="next-year">
                                                        <pre class="m-0"> > </pre>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- CALENDAR BODY START -->
                                            <div class="calendar-body">
                                                <div class="calendar-week-day">
                                                    <div>Sun</div>
                                                    <div>Mon</div>
                                                    <div>Tue</div>
                                                    <div>Wed</div>
                                                    <div>Thu</div>
                                                    <div>Fri</div>
                                                    <div>Sat</div>
                                                </div>
                                                <div class="calendar-day">
                                                    <div>
                                                        1
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <div>2</div>
                                                    <div>3</div>
                                                    <div>4</div>
                                                    <div>5</div>
                                                    <div>6</div>
                                                    <div>7</div>
                                                    <div>1</div>
                                                    <div>2</div>
                                                    <div>3</div>
                                                    <div>4</div>
                                                    <div>5</div>
                                                    <div>6</div>
                                                    <div>7</div>
                                                </div>
                                            </div>
                                            <!-- CALENDAR FOOTER START -->
                                            <div class="calendar-footer d-none">
                                                <div class="toggle">
                                                    <span>Dark Mode</span>
                                                    <div class="dark-mode-switch">
                                                        <div class="dark-mode-switch-ident"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="month-list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        url: "{{ route('student.cancleclass') }}",
                        type: "get",
                        data: {
                            'active': active,
                        },
                        success: function(response) {
                            console.log(response);
                                window.location = "{{ url('/')}}"+"/student/my-classes";
                            $('.pre-loader').hide();
                        }
                    });
                }
                })
        });

    $(document).ready( function (){
        $('.currDate').addClass('today');
    });

   function TimeZone(){
        $('#exampleModalCenter').modal('show');
   }
   function getMonthNumberFromName(monthName) {
        const year = new Date().getFullYear();
        return new Date(`${monthName} 1, ${year}`).getMonth() + 1;
    }

   $(document).on('click','.calendarDayHover',function(){
        $('.uc-table').html('<p class="text-center mt-5"><i class="fa fa-spinner fa-spin" style="font-size:200px;color:gray"></i></p>');
        $('.calendarDayHover').removeClass('currDate');
        var date = $(this).text().trim();
        var mon = getMonthNumberFromName($('.month-picker').text().trim());
        var year = $('.year-picker #year').text().trim();
        fdate = date+'-'+mon+'-'+year;
        $(this).addClass('currDate');
        // alert(fdate);

        var date = fdate;
        $.ajax({
            url: "{{ url('student/my-classes/') }}/?date="+date,
            type: 'GET',
            data: {},
            dataType: 'json',
            success: function(data) {
                if(data.status==true)
                {
                    $('.uc-table').html(data.html);
                }
                else{
                    $('.uc-table').html('');
                }
            }
        });
    });

    //Dark Mode Toggle
    document.querySelector('.dark-mode-switch').onclick = () => {
        document.querySelector('body').classList.toggle('dark');
        document.querySelector('body').classList.toggle('light');
    };

    //Check Year
    isCheckYear = (year) => {
        return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
            (year % 100 === 0 && year % 400 === 0)
    };

    getFebDays = (year) => {
        return isCheckYear(year) ? 29 : 28
    };

    let calendar = document.querySelector('.calendar');
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December'
    ];
    let monthPicker = document.querySelector('#month-picker');

    monthPicker.onclick = () => {
        monthList.classList.add('show')
    };

    //Generate Calendar
    generateCalendar = (month, year) => {
        let calendarDay = document.querySelector('.calendar-day');
        calendarDay.innerHTML = '';

        let calendarHeaderYear = document.querySelector('#year');
        let daysOfMonth = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        let currDate = new Date();

        monthPicker.innerHTML = monthNames[month];
        calendarHeaderYear.innerHTML = year;

        let firstDay = new Date(year, month, 1);

        for (let i = 0; i <= daysOfMonth[month] + firstDay.getDay() - 1; i++) {
            let day = document.createElement('div')
            if (i >= firstDay.getDay()) {


                day.innerHTML = i - firstDay.getDay() + 1
                day.innerHTML += `<span></span>
                             <span></span>
                             <span></span>
                             <span></span>`;
                if (i - firstDay.getDay() + 1 >= currDate.getDate() && year >= currDate.getFullYear() && month >= currDate.getMonth()) {
                    day.classList.add('calendarDayHover');
                }
                else{
                    day.classList.add('day-dis');
                }

                if (i - firstDay.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month ===
                    currDate.getMonth()) {
                    day.classList.add('currDate')
                }
            }
            calendarDay.appendChild(day)
        };
    };

    let monthList = calendar.querySelector('.month-list');
    monthNames.forEach((e, index) => {
        let month = document.createElement('div')
        month.innerHTML = `<div>${e}</div>`
        month.onclick = () => {
            monthList.classList.remove('show')
            currMonth.value = index
            generateCalendar(currMonth.value, currYear.value)
        }
        monthList.appendChild(month)
    });

    document.querySelector('#prev-year').onclick = () => {
        --currYear.value
        generateCalendar(currMonth.value, currYear.value)
    };

    document.querySelector('#next-year').onclick = () => {
        ++currYear.value
        generateCalendar(currMonth.value, currYear.value)
    };

    let currDate = new Date();
    let currMonth = {
        value: currDate.getMonth()
    };
    let currYear = {
        value: currDate.getFullYear()
    };

    generateCalendar(currMonth.value, currYear.value);

    $(document).on('click','.row-action',function(){
        window.open($(this).data('url'),'_blank');
    });

    $(document).on('click','.not-ready',function(){
        Swal.fire({
                title: 'Not Ready Yet',
                icon: 'info',
                })
    })
    </script>
@endpush

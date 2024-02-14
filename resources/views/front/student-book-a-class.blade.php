﻿@extends('layouts.student.master')
@section('content')
<style>
    .mw-80 {
        max-width: 80px;
    }
.rating{
    min-height:50px;
}
    .student-ticket-view {
        width: 70%;
    }
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
  font-family: Times; /* make sure ★ appears correctly*/
  line-height: 1;
}
.Stars:before {
    content: '★★★★★';
    letter-spacing: -5px;
    background : linear-gradient(0deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    -moz-background : linear-gradient(0deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    background : -webkit-linear-gradient(0deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}


</style>
<div class="course-student-header d-none">
    <div class="container">
        <div class="student-group">
            <div class="course-group ">
                <div class="course-group-img d-flex">
                    <a href="#"><img src="assets/img/user/user11.jpg" alt="" class="img-fluid"></a>
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
    <section class="section bg-light pt-5">
        <div class="container">
            <div class="section-header aos" data-aos="fade-up">
                <div class="section-sub-head">
                    <h2>Start learning German with one of these top teachers</h2>
                </div>

            </div>
            <!-- <div class="section-text aos" data-aos="fade-up">
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eget aenean accumsan
                    bibendum gravida maecenas augue elementum et neque. Suspendisse imperdiet.</p>
            </div> -->
            <div class="course-feature">
                <div class="row">
                    @php
                    $bookclasses = Helper::bookclasses();
                    @endphp
                    @if(isset($bookclasses))
                    @foreach($bookclasses as $bclass)
                    @php
                        $findTeacherdetails = Helper::findTeacherdetails($bclass->teacher_id);
                        $teacher11 = DB::table('users')->where('id', $bclass->teacher_id)->where('status',1)->first();
                    @endphp
                    @if($teacher11)
                    <div class="col-lg-4 col-md-6 d-flex">
                        <div class="course-box d-flex aos" data-aos="fade-up">
                            <div class="product">
                                <div class="product-img">
                                    <a href="#">
                                        <iframe width="100%" height="200" src="{{ $bclass->youtube_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </a>
                                    <div class="price d-none">
                                        <h3>$300 <span>$99.00</span></h3>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="course-group d-flex">
                                        <div class="course-group-img d-flex">
                                            @if(isset($findTeacherdetails))
                                                @if($findTeacherdetails->avatar)
                                                <a href="{{ url('student/class_details',['id'=>$bclass->id]) }}"><img src="{{ url('uploads/user/avatar/'.$findTeacherdetails->avatar) }}" alt="" class="img-fluid"></a>
                                                @else
                                                <a href="{{ url('student/class_details',['id'=>$bclass->id]) }}"><img src="{{ asset('/assets/img/user/user.png') }}" alt="" class="img-fluid"></a>
                                                @endif
                                            @endif
                                            <div class="course-name">
                                                @php
                                                $findTeacherName = Helper::findTeacherName($bclass->teacher_id);
                                                @endphp
                                                <h4><a href="{{ url('student/class_details',['id'=>$bclass->id]) }}">{{ $findTeacherName?$findTeacherName->name:'--' }}</a></h4>
                                                <p>Professional Teacher</p>
                                            </div>
                                        </div>
                                        <div class="course-share d-flex align-items-center justify-content-center">
                                            @php
                                            $wishlist = App\Models\wishlist::where('class_id',$bclass->id)->where('user_id',Auth::user()->id)->get();
                                            $wish_count = count($wishlist);
                                            @endphp
                                            @if($wish_count)
                                            <a href="{{url('/wishlist/remove',['id'=>$bclass->id])}}"><i class="fa fa-heart"></i></a>
                                            @else
                                            <a href="{{url('/wishlist',['id'=>$bclass->id])}}"><img src="{{asset('assets/img/icon/wish.svg')}}" alt="img"></a>
                                            @endif
                                        </div>
                                    </div>
                                    <h3 class="title instructor-text">
                                        <a href="{{ url('student/class_details',['id'=>$bclass->id]) }}">{!! substr($bclass->description,0,85) !!} ....</a>
                                    </h3>
                                    <div class="course-info d-flex align-items-center">
                                        <div class="rating-img d-flex align-items-center">
                                            <img src="{{ asset('assets/img/speaking-head.png') }}" style="width:24px;" alt="">&nbsp&nbsp
                                            @php
                                            $findTeacherdetails = Helper::findTeacherdetails($bclass->teacher_id);
                                            $lang_data = ($findTeacherdetails!=null && $findTeacherdetails->language!=null)?json_decode($findTeacherdetails->language):array();
                                            @endphp

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
                                        </div>
                                    </div>
                                    <div class="rating">
                                    @if($bclass->rating/2 != 0)
                                    <div class="Stars" style="--rating: {{$bclass->rating/2}};" aria-label="Rating of this product is 2.3 out of 5."></div>
                                    <span class="d-inline-block average-rating"><span>{{$bclass->rating/2 ?? ''}}</span></span>
                                    @endif
                                    </div>
                                    <div class="all-btn all-category d-flex align-items-center">
                                        <a href="{{ url('student/class_details',['id'=>$bclass->id]) }}" class="btn btn-primary">Book a class</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <h1>No Data Found</h1>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('script')
<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>
<script src="assets/js/script.js"></script>
<script>
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
                day.classList.add('calendarDayHover')
                day.innerHTML = i - firstDay.getDay() + 1
                day.innerHTML += `<span></span>
                             <span></span>
                             <span></span>
                             <span></span>`
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
</script>
@endpush
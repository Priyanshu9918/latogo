@extends('layouts.student.master')
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

    .no_order_div i {
        font-size: 50px;
    }
</style>
<div class="course-student-header d-none">
    <div class="container">
        <div class="student-group">
            <div class="course-group ">
                <div class="course-group-img d-flex">
                    <a href="student-profile.html"><img src="assets/img/user/user11.jpg" alt="" class="img-fluid"></a>
                    <div class="d-flex align-items-center">
                        <div class="course-name">
                            <h4><a href="student-profile.html">Rolands R</a><span>Beginner</span></h4>
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
                <li><a class="active" href="deposit-student-dashboard.html">Dashboard</a></li>
                <li><a href="course-student.html">Courses</a></li>
                <li><a href="course-wishlist.html">Wishlists</a></li>
                <li><a href="course-message.html">Messages</a></li>
                <li><a href="purchase-history.html">Purchase history</a></li>
                <li><a href="deposit-student.html">Deposit</a></li>
                <li class="mb-0"><a href="#">Transactions</a></li>
            </ul>
        </div>
    </div>
</div>
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
                                    <a><img class="avtar-style" src="{{asset('uploads/user/avatar/'.$student1->avtar)}}" alt="" class="img-fluid"></a>
                                    @else
                                    <img class="avtar-style" src="{{asset('assets/user.jpg')}}" alt="" class="img-fluid">
                                    @endif
                                </div>
                                <div class="instructor-inner">
                                    <h4 class="fs-18">{{Auth::user()->name;}}</h4>
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
                    <div class="col-md-2 d-flex">
                        <div class="card instructor-card w-100">
                            <div class="card-body text-center align-items-center justify-content-center d-flex">
                                <div class="instructor-inner">
                                @php
                                    $date = new \DateTime();
                                    $date->setTimezone(new \DateTimeZone('UTC')); //$tz
                                    $cur_date = $date->format('Y-m-d H:i:s');

                                    $upcommit = App\Models\BookSession::where('student_id',auth()->user()->id)
                                                ->whereDate('end_time', '>', $cur_date)
                                                ->where('is_cancelled',0)
                                                ->orderBy('id','DESC')
                                                ->get();
                                @endphp
                                    <h4 class="#">{{ count($upcommit) }}</h4>
                                    <p>Upcoming Lessons</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex">
                        <div class="card instructor-card w-100">
                            <div class="card-body text-center align-items-center justify-content-center d-flex">
                                <a href="{{ url('student/student-my-order') }}">
                                    <div class="instructor-inner">
                                        <?php
                                        $Purchased = DB::table('orders')->where('user_id', $user_id)->where('is_completed', 1)->get()->count();
                                        ?>
                                        <h4 href="{{ url('student/student-my-order') }}">{{ $Purchased }}</h4>
                                        <p>Purchased</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex">
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
                    <div class="col-md-2 d-flex">
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
                                    <p class="p-0 m-0">{{$timezone1->timezone ?? ''}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="settings-widget">
                                        <div class="settings-inner-blk p-0">
                                            <div class="sell-course-head comman-space">
                                                <h3>Orders</h3>
                                                <p>Order Dashboard is a quick overview of all current orders.
                                                </p>
                                            </div>
                                            <div class="comman-space pb-0">
                                                @if(count($order_data)>0)
                                                <div class="settings-tickets-blk course-instruct-blk table-responsive">
                                                    <table class="table table-nowrap mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>COURSES</th>
                                                                <th>SALES</th>
                                                                <th>INVOICE</th>
                                                                <th>DATE</th>
                                                                <th>METHOD</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                
                                                            @foreach($order_data as $o_data)

                                                            <?php $order_item1 = DB::table('order_items')->where('order_id',$o_data->id)->get();
                                                            ?>
                                                                <td class="instruct-orders-info">
                                                                    @foreach($order_item1 as $order_items1)
                                                                    <?php if (isset($order_items1->class_id)) {
                                                                        $priceval = DB::table('pricings')->where('id', $order_items1->class_id)->first();
                                                                        $courses = DB::table('price_masters')->where('id', $priceval->price_master)->first();
                                                                    } ?>
                                                                    <p><a href="">{{ isset($courses->title)?$courses->title:'' }} / {{ isset($priceval->time)?$priceval->time:'' }} min/ {{ isset($priceval->totle_class)?$priceval->totle_class:'' }}x Classes</a></p>
                                                                    @endforeach
                                                                </td>
                                                                <td class="instruct-orders-info">
                                                                    @foreach($order_item1 as $order_items2)
                                
                                                                    <p>{{ $order_items2->quantity }}</p>
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ $o_data->order_no }}</td>
                                                                <td>{{ $o_data->created_at }}</td>
                                                                <td>{{ $o_data->payment_method }}</td>
                                                                <td><a href="{{ url('student/student-my-order-details',['id'=>(base64_encode($o_data->id))]) }}"><button class="btn btn-primary btn-filled">View</button></a></td>
                                                                <?php $priceval = DB::table('subscription_credit')->where('order_id', $o_data->id)->first();   ?>
                                                                @if($o_data->payment_method  == 'Stripe' && isset($priceval))
                                                                    @if(isset($priceval)  && $priceval->status == 1)
                                                                    <td><a href="{{ url('student/subscription-calcle',['id'=>(base64_encode($o_data->stripe_order_id))]) }}"><button class="btn btn-success">Active Subscription</button></a></td>
                                                                    @else
                                                                    <td><a href="{{ url('student/subscription-calcle1',['id'=>(base64_encode($o_data->stripe_order_id))]) }}"><button class="btn btn-danger">Inactive Subscription</button></a></td>
                                                                    @endif
                                                                @endif
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <div class="no_order_div py-5 text-center">
                                                    <svg style="max-width: 50px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                    </svg>

                                                    <h4  class="fs-4 pt-3 mb-2 fw-bold">No orders found</h4>
                                                    <p class="text-black-50">We could not find any orders matching this status.</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="light">
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
                if (i - firstDay.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() &&
                    month ===
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

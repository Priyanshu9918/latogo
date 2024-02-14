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
    </style>
        <div class="course-student-header d-none">
            <div class="container">
                <div class="student-group">
                    <div class="course-group ">
                        <div class="course-group-img d-flex">
                            <a href="student-profile.html"><img src="{{asset('assets/img/user/user11.jpg')}}" alt=""
                                    class="img-fluid"></a>
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
                        <li class="mb-0"><a href="transactions-student.html">Transactions</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="container">
                <div class="row">

                    <div class="col-xl-12 col-md-12">
                        <div class="settings-top-widget student-deposit-blk">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-sub-head">
                                        <h2 class="mb-4 text-center">3 Steps how to get started :</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card stat-info ttl-tickets">
                                        <div class="card-body">
                                            <div class="view-all-grp d-flex align-items-center">
                                                <div class="student-ticket-view">
                                                    <h3 class="mb-0">1. Choose a Teacher</h3>
                                                </div>
                                                <div class="img-deposit-ticket">
                                                    <img src="{{asset('assets/img/students/choose.png')}}" class="w-100 mw-80"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card stat-info open-tickets">
                                        <div class="card-body">
                                            <div class="view-all-grp d-flex align-items-center">
                                                <div class="student-ticket-view">
                                                    <h3 class="mb-0">2. Book your class</h3>
                                                </div>
                                                <div class="img-deposit-ticket">
                                                    <img src="{{asset('assets/img/students/class.png')}}" class="w-100 mw-80" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card stat-info close-tickets">
                                        <div class="card-body">
                                            <div class="view-all-grp d-flex align-items-center">
                                                <div class="student-ticket-view">
                                                    <h3 class="mb-0">3. Speak German with confidence</h3>
                                                </div>
                                                <div class="img-deposit-ticket">
                                                    <img src="{{asset('assets/img/students/speak.png')}}" class="w-100 mw-80" alt="">
                                                </div>
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
                                                    <div
                                                        class="settings-tickets-blk course-instruct-blk table-responsive">
                                                        <table class="table table-nowrap mb-2">
                                                            <tbody>
                                                                @if(count($upcommit) != 0)
                                                                @foreach($upcommit as $key => $val)
                                                                        @php
                                                                            $t1 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                                                                            $t1->setTimezone(new \DateTimeZone($tz));
                                                                            $times = $t1->format("Y-m-d H:i");
                                                                            $showT = $t1->format("d.m.Y - h:i A");
                                                                        @endphp
                                                                        <tr class="row-action" data-url="{{ $val->student_url }}">
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
                                                            @else
                                                            <div class="no_order_div py-5 text-center">
                                                                <svg style="max-width: 50px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                </svg>
                                                                <h4  class="fs-4 pt-3 mb-2 fw-bold">No lesson found</h4>
                                                                <p class="text-black-50">We could not find any lessons.</p>
                                                            </div>
                                                            @endif
                                                                {{-- <tr>
                                                                    <td>
                                                                        <div
                                                                            class="sell-table-group d-flex align-items-center">
                                                                            <div class="sell-group-img">
                                                                                <a href="#">
                                                                                    <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                        class="img-fluid " alt="">
                                                                                </a>
                                                                            </div>
                                                                            <div class="sell-tabel-info">
                                                                                <p><a href="#">Henning Gustavsen</a></p>
                                                                                <div
                                                                                    class="rating-img d-flex align-items-center">
                                                                                    <p class="m-0 light-g">Lesson ID:
                                                                                        9874563215</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="sell-tabel-info">
                                                                            <p class="m-0"><a href="#">Slide Through! B1
                                                                                    - B2 Kurs</a></p>
                                                                            <div
                                                                                class="rating-img d-flex align-items-center">
                                                                                <p class="m-0 light-g">German - 60 min
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="sell-tabel-info text-center">
                                                                            <p class="m-0"><a href="#">Your lesson will
                                                                                    start in</a></p>
                                                                            <div
                                                                                class="rating-img justify-content-center d-flex align-items-center">
                                                                                <p class="m-0 countdown-text-ds">16h 29m
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
                                                                                        class="img-fluid " alt="">
                                                                                </a>
                                                                            </div>
                                                                            <div class="sell-tabel-info">
                                                                                <p><a href="#">Henning Gustavsen</a></p>
                                                                                <div
                                                                                    class="rating-img d-flex align-items-center">
                                                                                    <p class="m-0 light-g">Lesson ID:
                                                                                        9874563215</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="sell-tabel-info">
                                                                            <p class="m-0"><a href="#">Slide Through! B1
                                                                                    - B2 Kurs</a></p>
                                                                            <div
                                                                                class="rating-img d-flex align-items-center">
                                                                                <p class="m-0 light-g">German - 60 min
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="sell-tabel-info text-center">
                                                                            <p class="m-0"><a href="#">Your lesson will
                                                                                    start in</a></p>
                                                                            <div
                                                                                class="rating-img justify-content-center d-flex align-items-center">
                                                                                <p class="m-0 countdown-text-ds">16h 29m
                                                                                    08s</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr> --}}
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card instructor-card">
                                        <div class="card-body">
                                            <div class="card-body">
                                                <h5 class="subs-title">Monthly progress</h5>
                                                <div class="contact-info-list d-none">
                                                    <div class="edu-wrap">
                                                        <div class="edu-name">
                                                            <span><img src="{{asset('assets/img/instructor/email-icon.png')}}"
                                                                    alt="Address"></span>
                                                        </div>
                                                        <div class="edu-detail">
                                                            <h6>Email</h6>
                                                            <p><a href="javascript:;">jennywilson@example.com</a></p>
                                                        </div>
                                                    </div>
                                                    <div class="edu-wrap">
                                                        <div class="edu-name">
                                                            <span><img src="{{asset('assets/img/instructor/address-icon.png')}}"
                                                                    alt="Address"></span>
                                                        </div>
                                                        <div class="edu-detail">
                                                            <h6>Address</h6>
                                                            <p>877 Ferry Street, Huntsville, Alabama</p>
                                                        </div>
                                                    </div>
                                                    <div class="edu-wrap">
                                                        <div class="edu-name">
                                                            <span><img src="{{asset('assets/img/instructor/phone-icon.png')}}"
                                                                    alt="Address"></span>
                                                        </div>
                                                        <div class="edu-detail">
                                                            <h6>Phone</h6>
                                                            <p> <a href="javascript:;">+1(452) 125-6789</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="weeklychart"></div>
                                            </div>
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
    <script>
        var options = {
          series: [{
            name: 'Orders',
            data: @json($data1)
        }, {
            name: 'Credits',
            data: @json($data2)
        }],
          chart: {
          type: 'bar',
          height: 300,
          toolbar: {
            show: false
            }
        },
        plotOptions: {
          bar: {
            horizontal: true,
            dataLabels: {
              position: 'top',
            },
          }
        },
        dataLabels: {
          enabled: true,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: @json($data0),
        },
        colors: ['#4c52e1', '#f6697b'],
        };

        var chart = new ApexCharts(document.querySelector("#weeklychart"), options);
        chart.render();

        $(document).on('click','.row-action',function(){
            window.open($(this).data('url'),'_blank');
        });
    </script>
@endpush

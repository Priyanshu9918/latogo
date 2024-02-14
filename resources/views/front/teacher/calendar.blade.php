@extends('layouts.teacher.master')
@section('content')
<style>
	.weeklist div.fw-bold:first-child{
		flex-basis: 20%;
	}
	.weeklist .fa-plus{
		cursor: pointer;
	}
	.weeklist{
		border: 1px solid #e9ecef;
		background-color: #fff;
		padding:10px 20px;
		border-radius: 5px;
		margin-top:10px;
		position: relative;
	}
	.f-basis-45{
		flex-basis: 45%;
	}
	.filter-menu{
		display:none;
	    position: absolute;
		top: 40px;
		background: #fff;
		padding: 15px 20px;
		border: 1px solid #00000029;
		right: -50px;
		z-index: 99;
		box-shadow: 2px 2px 8px #0000001f;
	}
	.nav-tabs{
		width: fit-content;
		background-color: #4c52e1;
		margin: auto;
		    border-radius: 10px;
			    overflow: hidden;
		border-bottom:none;
	}
	.nav-tabs .nav-link{
		color: #fff;
		border: 4px solid #4c52e1 !important;
		/* border: none !important; */
		border-radius: 10px;
		font-weight: 600;
	}
	.nav-tabs .nav-link.active {
		color: #4c52e1;
		background-color: #fff;
		border-color: #dee2e6 #dee2e6 #fff;
		border: 4px solid #4c52e1 !important;
		border-radius: 10px;
	}
    .toastui-calendar-panel.toastui-calendar-time{
        height: 550px !important;
    }
    .toastui-calendar-timegrid-now-indicator {
        display: none !important;
    }
    @media (max-width: 600px) {
        .toastui-calendar-timegrid-time-column{
            width: 40px !important;
        }
        .toastui-calendar-columns{
            left: 40px !important;
        }
        .toastui-calendar-day-name-container{
            margin-left: 40px!important;
        }
    }
    .toastui-calendar-event-time {
            width: 100% !important;
            left: 0px !important;
            margin-left: 0px !important;
        }
        table.dataTable{
            width: 100% !important;
        }
</style>
@if(Session::has('success'))<div class="alert alert-success my-toast">{{Session::get('success')}}</div>@endif
@if(Session::has('error'))<div class="alert alert-danger my-toast">{{Session::get('error')}}</div>@endif
<div class="msg-sec"></div>
<link rel="stylesheet" href="{{ asset('assets/css/date-style.css') }}">
<div class="page-content instructor-page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Availability </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Calendar</button>
                  </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="my-3 text-center ">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"> Unavailability</button>
                                <button class="btn btn-primary" id="removeunvaibility">Remove Unavailability</button>
                            </div>
                            <div class="row justify-content-center mt-4">
                            <div class="col-md-8">
                                <h3>Set your weekly hours</h3>
                                <form action="{{ route('teacher.availability.update') }}" method="post">
                                    @csrf
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <div class="fw-bold">Sunday</div>
                                        @if(count($times1)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif
                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="1">
                                                @if(count($times1)>0)
                                                    @foreach($times1 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f1[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="t1[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f1[]" data-t="t1[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu" data-id="1">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Monday
                                                        <input class="form-check-input" type="checkbox" value="2">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Tuesday
                                                        <input class="form-check-input" type="checkbox" value="3">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Wednesday
                                                        <input class="form-check-input" type="checkbox" value="4">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Thursday
                                                        <input class="form-check-input" type="checkbox" value="5">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Friday
                                                        <input class="form-check-input" type="checkbox" value="6">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Saturday
                                                        <input class="form-check-input" type="checkbox" value="7">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between">
                                        <div class="fw-bold">Monday</div>
                                        @if(count($times2)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="2">
                                                @if(count($times2)>0)
                                                    @foreach($times2 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f2[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="t2[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f2[]" data-t="t2[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu" data-id="2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Sunday
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Tuesday
                                                        <input class="form-check-input" type="checkbox" value="3">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Wednesday
                                                        <input class="form-check-input" type="checkbox" value="4">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Thursday
                                                        <input class="form-check-input" type="checkbox" value="5">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Friday
                                                        <input class="form-check-input" type="checkbox" value="6">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Saturday
                                                        <input class="form-check-input" type="checkbox" value="7">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <div class="fw-bold">Tuesday</div>
                                        @if(count($times3)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="3">
                                                @if(count($times3)>0)
                                                    @foreach($times3 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f3[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="t3[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f3[]" data-t="t3[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu" data-id="3">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Sunday
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Monday
                                                        <input class="form-check-input" type="checkbox" value="2">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Wednesday
                                                        <input class="form-check-input" type="checkbox" value="4">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Thursday
                                                        <input class="form-check-input" type="checkbox" value="5">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Friday
                                                        <input class="form-check-input" type="checkbox" value="6">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Saturday
                                                        <input class="form-check-input" type="checkbox" value="7">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <div class="fw-bold">Wednesday</div>
                                        @if(count($times4)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="4">
                                                @if(count($times4)>0)
                                                    @foreach($times4 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f4[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="t4[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f4[]" data-t="t4[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu"  data-id="4">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Sunday
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Monday
                                                        <input class="form-check-input" type="checkbox" value="2">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Tuesday
                                                        <input class="form-check-input" type="checkbox" value="3">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Thursday
                                                        <input class="form-check-input" type="checkbox" value="5">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Friday
                                                        <input class="form-check-input" type="checkbox" value="6">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Saturday
                                                        <input class="form-check-input" type="checkbox" value="7">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <div class="fw-bold">Thursday</div>
                                        @if(count($times5)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="5">
                                                @if(count($times5)>0)
                                                    @foreach($times5 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f5[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="t5[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f5[]" data-t="t5[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu" data-id="5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Sunday
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Monday
                                                        <input class="form-check-input" type="checkbox" value="2">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Tuesday
                                                        <input class="form-check-input" type="checkbox" value="3">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Wednesday
                                                        <input class="form-check-input" type="checkbox" value="4">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Friday
                                                        <input class="form-check-input" type="checkbox" value="6">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Saturday
                                                        <input class="form-check-input" type="checkbox" value="7">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <div class="fw-bold">Friday</div>
                                        @if(count($times6)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="6">
                                                @if(count($times6)>0)
                                                    @foreach($times6 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f6[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="t6[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f6[]" data-t="t6[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu" data-id="6">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Sunday
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Monday
                                                        <input class="form-check-input" type="checkbox" value="2">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Tuesday
                                                        <input class="form-check-input" type="checkbox" value="3">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Wednesday
                                                        <input class="form-check-input" type="checkbox" value="4">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Thursday
                                                        <input class="form-check-input" type="checkbox" value="5">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Saturday
                                                        <input class="form-check-input" type="checkbox" value="7">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <div class="fw-bold">Saturday</div>
                                        @if(count($times7)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="7">
                                                @if(count($times7)>0)
                                                    @foreach($times7 as $day)
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                                            @php
                                                                $time_from  = date('Y-m-d').' '.$day->time_from;
                                                                $time_to    = date('Y-m-d').' '.$day->time_to;

                                                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                                                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                                                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                                                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                                                                $tf_time    = $time_from_t1->format("h:i A");
                                                                $tt_time    = $time_to_t1->format("h:i A");
                                                            @endphp
                                                            <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="f7[]" value="{{$tf_time}}" />
                                                            <label class="m-0">-</label>
                                                            <input type="text" placeholder="To :" class="form-control timepicker f-basis-45" name="t7[]" value="{{$tt_time}}" />
                                                            <i class="fa-solid fa-trash removeMon"></i>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class=" d-flex ">
                                            <div class="pe-2"><i class="fa-solid addItembtn fa-plus" data-f="f7[]" data-t="t7[]"></i></div>
                                            <div class="pe-2 filterbtn"><i class="fa-solid fa-rotate"></i></div>
                                            <div class="filter-menu" data-id="7">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Sunday
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Monday
                                                        <input class="form-check-input" type="checkbox" value="2">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Tuesday
                                                        <input class="form-check-input" type="checkbox" value="3">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Wednesday
                                                        <input class="form-check-input" type="checkbox" value="4">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Thursday
                                                        <input class="form-check-input" type="checkbox" value="5">
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Friday
                                                        <input class="form-check-input" type="checkbox" value="6">
                                                    </label>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-filled ap-btn">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="weeklist d-block d-md-flex justify-content-between	">
                                        <button type="submit" class="btn btn-primary w-100" >Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        {{-- <div style=" min-height: 1500px;" id='calendar'></div> --}}
                        <div class="container p-0 " style="height: 100% !important;">
                            <div class="my-3 text-center text-lg-start">
                                <button class="btn btn-primary btn-prev"> <i class="fa fa-angle-left"></i></button>
                                <button class="btn btn-primary btn-today">Today</button>
                                <button class="btn btn-primary btn-nxt"> <i class="fa fa-angle-right"></i></button>
                                <span class="navbar12"></span>
                            </div>
                            <div id="container" style="min-height: 600px !important;height:600px"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold">Set Unavailability<span class="credit1"></span></h4>
            </div>
            <div class="modal-body flex-grow-0" >
                <form id="unavailability">
                    @csrf
                    <div class="container">
                        <label class="fw-bold" for="dt">Date</label>
                        <input type="date" class="form-control" id="dt" name="date">
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-date"></p>
                    </div>
                    <div class="container">
                        <label class="fw-bold" for="tf">Time From</label>
                        <input type="time" class="form-control" id="tf" name="time_from">
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time_from"></p>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <div class="container">
                        <label class="fw-bold" for="tt">Time To</label>
                        <input type="time" class="form-control" id="tt" name="time_to">
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time_to"></p>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <div class="container text-center">
                        <button type="button" class="btn btn-primary set-un" >Set</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="remove1" tabindex="-1" role="dialog" aria-labelledby="remove1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold">Manage Unavailability<span class="credit1"></span></h4>
            </div>
            @php
                $unvalibility = DB::table('unavailabilities')->where('teacher_id', Auth::user()->id)->get();
            @endphp
            <div class="modal-body flex-grow-0" >
                <div class="col-12 table-responsive">
                <table id="table_id" class="table">
                    <thead style="background:#a0b8ed29;">
                    <tr>
                        <th> SNo.</th>
                        <th><b>Start Time</b></th>
                        <th><b>End Time</b></th>
                        <th><b>Action</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($unvalibility as $key => $wallets)
                    <tr>
                        <td>{{++$key}}</td>
                        <td><span style="color:red; font-weight:bold; font-size:16px"></span>{{$wallets->start_time}}</td>
                        <td>{{$wallets->end_time}}</td>
                        <td><a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover deleteBtn"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Delete" href="javascript:void(0)" data-id="{{base64_encode($wallets->id)}}">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fas fa-trash text-danger"></i>
                                    </span>
                                </span>
                            </a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">Empty!</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets/js/date-script.js') }}"></script>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js'></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js">
    </script><link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.ie11.min.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
		//   var calendarEl = document.getElementById('calendar');

		//   var calendar = new FullCalendar.Calendar(calendarEl, {
		// 	timeZone: 'UTC',
		// 	dayMaxEvents: true, // allow "more" link when too many events
		// 	// events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
        //     events: 'http://127.0.0.1:8000/sample.json'
		//   });

		//   calendar.render();
		// });
		// $(document).ready(function(){
			$(document).on('click','#profile-tab', function(){
			// 	var calendarEl = document.getElementById('calendar');

			// 	  var calendar = new FullCalendar.Calendar(calendarEl, {
			// 		timeZone: 'UTC',
			// 		dayMaxEvents: true, // allow "more" link when too many events
			// 		// events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
            //         events: 'http://127.0.0.1:8000/sample.json',
            //         initialView: 'timeGridWeek',
			// 	  });

			// 	  calendar.render();
            $('#container').html('');
                var x = setTimeout(() => {
                    cal_init();
                    $('.btn-today').click();
                }, 500);

			});



			$(document).on('click','.addItembtn', function(){
				// $(".monday-div .slot-item").clone().appendTo("#monclonedata");
                let fname = $(this).data('f');
                let tname = $(this).data('t');
				var Sprnt = $(this).parent().parent().parent().find('.appendboxDate');
                var unLab = $(this).parent().parent().parent().find('.un-lable');
				var adhtml = `<div class="slot-item d-flex align-items-center justify-content-between mb-3">
                                <input type="text" placeholder="From :" class="form-control timepicker f-basis-45" name="`+fname+`" />
                                <label class="m-0">-</label>
                                <input type="text"  placeholder="To :" class="form-control timepicker f-basis-45" name="`+tname+`" />
                                <i class="fa-solid fa-trash removeMon"></i>
                            </div>`;
				Sprnt.append(adhtml);
                unLab.remove();
				$('.timepicker').mdtimepicker();
			});
			$(document).on('click','.removeMon',function() {
				let clsName = $(this).parent().parent().parent();
				$(this).parent().remove();

                if(clsName.find('.slot-item').length <= 0)
                {
                    $('<div class="text-danger un-lable">Unavailable</div>').insertBefore(clsName);
                }
			});
			$(document).on('click','.filterbtn',function(){
                let th = $(this).next().data('id');
				$(this).next().toggle();
                $('div.filter-menu').each(function(){
                    if ( $(this).css('display') == 'block' && $(this).data('id')!=th)
                    {
                        $(this).css('display','none');
                    }
                });
			});

            $(document).on('click','.ap-btn',function() {

                var checkArr= [];
                var Sprnt   = $(this).parent().parent().parent().find('.appendboxDate');
                $(this).parent().find("input[type=checkbox]:checked").each(function(){
                    checkArr.push($(this).val());
                    $(this).prop('checked',false);
                });


                $('.appendboxDate').each(function(){

                    var temp    = $(this).data('id');
                    // var unLab   =
                    if($.inArray(temp.toString(),checkArr) >=0)
                    {
                        let fname = "f"+$(this).data('id')+"[]";
                        let tname = "t"+$(this).data('id')+"[]";

                        $(this).parent().parent().find('.un-lable').remove();
                        $(this).html(Sprnt.html());

                        $(this).find('input[type=text]').each(function(idx, el){
                            let num = idx+1;
                            if (num % 2 == 0)
                            {
                                $(this).attr('name',tname);
                            }
                            else{
                                $(this).attr('name',fname);
                            }
                        });
                    }
                });
                $('.timepicker').mdtimepicker();
                $('.filter-menu').hide();

            });



		// });
    </script>

    <script>
        function cal_init()
        {
            var Cal = tui.Calendar;
            var calendar = new Cal('#container', {
                defaultView: 'week',
                taskView: false,
                id: 'cal1',
                isReadOnly: true,
            });
            calendar.setOptions({
                week: {
                    taskView: false,
                    eventView: ['time'],
                    defaultTimeDuration : 30,
                }
            });
            calendar.createEvents(@json($events));

            var timedEvent = calendar.getEvent('1', 'cal1'); // EventObject
            calendar.on('clickEvent', ({ event }) => {
                console.log(event); // EventObject
                $('#date_time').val(event.body);

                console.log(event.attendees[0]);
                if(event.attendees[0]=='B')
                {
                    Swal.fire({
                        title: 'Booked by '+event.attendees[2],
                        text: '',
                        imageUrl: event.attendees[1],
                        imageWidth: 200,
                        imageHeight: 200,
                        imageAlt: 'Custom image',
                    })
                }

            });

            function getMonthName(monthNumber) {
                const date = new Date();
                date.setMonth(monthNumber);

                return date.toLocaleString('en-US', {
                    month: 'long',
                });
            }

            function updateNavbar() {
                const date = calendar.getDate();
                const month = date.getMonth();
                const month_name = getMonthName(month);
                const year = date.getFullYear();
                $('.navbar12').text(month_name + ' - ' + year);
            }

            $(document).on("click", ".btn-prev", function() {
                calendar.prev();
                updateNavbar();
                Zind();
            });

            $(document).on("click", ".btn-nxt", function() {
                calendar.next();
                updateNavbar();
                Zind();
            });

            $(document).on("click", ".btn-today", function() {
                calendar.today();
                updateNavbar();
                Zind();
            });

            // Initial update
            updateNavbar();
            Zind();
        }
    </script>
	<script>
	  $(document).ready(function(){
		$('.timepicker').mdtimepicker();
	  });
      $( window ).on("load", function() {
        cal_init();
      });

      $(document).on("click", ".set-un", function() {
        $('.error_container').html('');
        var dt = $('#dt').val();
        var tf = $('#tf').val();
        var tt = $('#tt').val();
        $.ajax({
            type:"post",
            url:"{{route('teacher.unavailability')}}",
            dataType: "json",
            data:{'time_from':tf,'time_to':tt,'date':dt,"_token": "{{ csrf_token() }}"},
            success:function(response)
            {
                if(response.status==true) {
                    $('.msg-sec').html('<div class="alert alert-success my-toast">'+response.msg+'</div>')
                    $("#unavailability")[0].reset();
                    $('#exampleModalCenter').modal('hide');
                    window.location.reload();
                }
                else{
                    $('.msg-sec').html('<div class="alert alert-danger my-toast">'+response.msg+'</div>')
                }

                setTimeout(() => {
                    $(".my-toast").delay(5000).fadeOut();
                }, 2000);

            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#error-' + key).text(value[0]);
                });
            }
        });
    });
    var un_av_tbl = $("#unvaildatatable").html();
    $(document).on('click','#removeunvaibility', function(){
        $('#remove1').modal('show');
    });
    $(document).on('click', '.deleteBtn', function() {

        var _this = $(this);
        // var result=confirm("Are You Sure You Want to Delete?");
        var id = $(this).data('id');
        var table = 'unavailabilities';
        Swal.fire({
                title: 'Do you want to remove this unavailability?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    _this.addClass('disabled-link');
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{route('teacher.delete-action')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                            'table_name': table
                        },
                        success: function(data) {
                            console.log(data);
                            window.setTimeout(function() {
                                _this.removeClass('disabled-link');
                            }, 2000);

                            if (data.code == 200) {
                                // toastr.success("unavailabilitie removed Successfully");
                                window.setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                    swal.close();
                } else {
                    swal.close();
                }
            }
        );
        });

        function Zind()
        {
            setTimeout( function(){
                $('.toastui-calendar-event-time').each(function(){
                    if($(this).attr('data-event-id')=='2')
                    {
                        $(this).css("z-index", "2")
                    }
                });
            }, 500);
            
        }
	</script>
@endpush
@endsection

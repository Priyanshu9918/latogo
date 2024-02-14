@extends('layouts.admin.master')
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
    .toastui-calendar-event-time {
        width: 100% !important;
        left: 0px !important;
        margin-left: 0px !important;
    }

    .sec-slot {
        background: red !important;
    }
</style>
@if(Session::has('success'))<div class="alert alert-success my-toast">{{Session::get('success')}}</div>@endif
@if(Session::has('error'))<div class="alert alert-danger my-toast">{{Session::get('error')}}</div>@endif

<link rel="stylesheet" href="{{ asset('assets/css/date-style.css') }}">
<div class="page-content instructor-page-content pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                <thead>
                    <tr style="background:#e5e5e5;">
                    <th scope="col">Country</th>
                    <th scope="col">TimeZone</th>
                    <th scope="col">Time</th>
                    </tr>
                </thead>
                @php
                    $user1 = DB::table('teacher_settings')->where('user_id',$user_id)->first();
                    $timezone = DB::table('time_zones')->where('id',$user1->timezone ?? 136)->first();
                    $tz = $timezone->timezone;
                    $dt = new DateTime("now", new DateTimeZone($tz));
                    $country1 = DB::table('countries')->where('id',$user1->country ?? 82)->first();
                    $timezone1 = DB::table('time_zones')->where('id',$user1->timezone ?? 136)->first();
                @endphp
                <tbody>
                    <tr>
                    <td>{{$country1->name ?? ''}}</td>
                    <td>{{$timezone1->timezone ?? ''}}</td>
                    <td>{{$dt->format('h:ia')}} (UTC {{$timezone->raw_offset}}.00)</td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="col-md-6 text-lg-center p-4">
                <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" class="btn btn-primary" style="color:white; border:double;">Schedule a class</a>
            </div>
        </div>
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
                        <div class="row justify-content-center mt-4">
                            <div class="col-md-8">
                                <h3>Set your weekly hours</h3>
                                <form action="{{ route('admin.availability.update',['id'=>base64_encode($user_id)]) }}" method="post">
                                    @csrf
                                    <input type="hidden" id="user_id" name="user_id" value="{{$user_id ?? ''}}">
                                    <div class="weeklist d-flex justify-content-between	">
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
                                    <div class="weeklist d-flex justify-content-between">
                                        <div class="fw-bold">Monday</div>
                                        @if(count($times2)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="2">
                                                @if(count($times2)>0)
                                                    @foreach($times2 as $day)
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
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
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
                                    <div class="weeklist d-flex justify-content-between	">
                                        <div class="fw-bold">Tuesday</div>
                                        @if(count($times3)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="3">
                                                @if(count($times3)>0)
                                                    @foreach($times3 as $day)
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
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
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
                                    <div class="weeklist d-flex justify-content-between	">
                                        <div class="fw-bold">Wednesday</div>
                                        @if(count($times4)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="4">
                                                @if(count($times4)>0)
                                                    @foreach($times4 as $day)
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
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
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
                                    <div class="weeklist d-flex justify-content-between	">
                                        <div class="fw-bold">Thursday</div>
                                        @if(count($times5)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="5">
                                                @if(count($times5)>0)
                                                    @foreach($times5 as $day)
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
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
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
                                    <div class="weeklist d-flex justify-content-between	">
                                        <div class="fw-bold">Friday</div>
                                        @if(count($times6)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="6">
                                                @if(count($times6)>0)
                                                    @foreach($times6 as $day)
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
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
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
                                    <div class="weeklist d-flex justify-content-between	">
                                        <div class="fw-bold">Saturday</div>
                                        @if(count($times7)==0)
                                        <div class="text-danger un-lable">Unavailable</div>
                                        @endif

                                        <div class="input-date-box">
                                            <div class="appendboxDate" data-id="7">
                                                @if(count($times7)>0)
                                                    @foreach($times7 as $day)
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
                                                        <div class="slot-item d-flex align-items-center justify-content-between mb-3">
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
                                    <div class="weeklist d-flex justify-content-between	">
                                        <button type="submit" class="btn btn-primary w-100" >Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        {{-- <div style=" min-height: 1500px;" id='calendar'></div> --}}
                        <div class="container" style="height: 100% !important;">
                            <div>
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
        <!-- //hiden input -->
<form action="" method="" class="d-none" id="boking_form">
    <input type="hidden" id="class_id" name="class_id" value="">
    <input type="hidden" id="t_credit" name="t_credit" value="">
    <input type="hidden" id="teacher_id" name="teacher_id" value="{{ $user_id}}">
    <input type="hidden" id="student_id" name="student_id" value="">
    <input type="hidden" id="date_time" name="date_time" value="">
    <input type="hidden" id="class_quee" name="class_quee" value="">
    <input type="hidden" id="user_id" value="{{$user_id}}">
</form>
@endsection
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="height:290px;">
                <div class="modal-header" style="background:#dbdbdb;">
                <h4 class="fw-bold">BOOK Classes<span class="credit1"></span></h4>
                </div>
                <div class="modal-body flex-grow-0" >
                <form action="{{route('admin.credit.add')}}" method="POST" id="createFrm">
                    @csrf
                    <input type="hidden" class="form-control" name="user_id" id="user1" value="" />
                    <input type="hidden" class="form-control" name="price_master" id="price_master" value="" />
                    <div class="container">
                        <label class="fw-bold" for="">Students</label>
                        <select class="form-select std" aria-label="Default select example" name="std" id="std_id">
                        <option>Select student</option>
                            @if(count($student_data)>0)
                                @foreach ($student_data as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}} ( {{$cat->email}} )</option>
                                @endforeach
                            @endif
                        </select>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="std1"></p>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <div class="container" id="tiz">
                        <label class="fw-bold" for="time_id">Time</label>
                        <select class="form-select time" aria-label="Default select example" name="time" id="time_id">
                        </select>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time"></p>
                    </div>
                </div>
                </form>
                </div>
            </div>
            </div>

            <div class="modal fade" id="schedule-calendar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                {{-- style="max-width:70%;" --}}
                <div class="modal-content selectplan">
                    <div class="modal-header">
                        <span><i class="fa-solid fa-chevron-left"></i></span>
                        <h1 class="modal-title fs-5">Schedule your lessons</h1>
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
                        <button type="button" class="btn btn-primary" id="submit-session">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/date-script.js') }}"></script>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js'></script>
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
                },
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
                        text: 'Modal with a custom image.',
                        imageUrl: event.attendees[1],
                        imageWidth: 200,
                        imageHeight: 200,
                        imageAlt: 'Custom image',
                    })
                }

            });

            // function getMonthName(monthNumber) {
            //     const date = new Date();
            //     date.setMonth(monthNumber);

            //     return date.toLocaleString('en-US', {
            //         month: 'long',
            //     });
            // }

            // const date = calendar.getDate();
            // const month = date.getMonth();
            // const month_name = getMonthName(month)
            // const year = date.getFullYear();
            // $('.navbar12').text(month_name+ ' - ' + year);

            // $(document).on("click", ".btn-prev", function() {
            //     calendar.prev();
            //     const date = calendar.getDate();
            //     const month = date.getMonth();
            //     const month_name = getMonthName(month)
            //     const year = date.getFullYear();
            //     $('.navbar12').text(month_name+ ' - ' + year);
            //     Zind();
            // });
            // $(document).on("click", ".btn-nxt", function() {
            //     calendar.next();
            //     const date = calendar.getDate();
            //     const month = date.getMonth();
            //     const month_name = getMonthName(month)
            //     const year = date.getFullYear();
            //     $('.navbar12').text(month_name+ ' - ' + year);
            //     Zind();
            // });
            // $(document).on("click", ".btn-today", function() {
            //     calendar.today();
            //     Zind();
            // });
            
            // Zind();

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
      $(document).on('change','.std',function(){
            var std = $('#std_id').val();
            $.ajax({
                type:"get",
                url:"{{route('admin.st_time')}}",
                data:{'std':std,"_token": "{{ csrf_token() }}"},
                success:function(response)
                {
                    if(response.success==true) {
                        $("#student_id").val(response.st_id);
                        var sizeOfArrray = response.data.length;
                        if(sizeOfArrray == 0){
                            $('#std1').html('Student has not enough credits, Kindly ask to purchase classes.');
                        }else{
                            $('#std1').empty();
                            $("#time_id").empty();
                            $("#time_id").html('<option value="">Select Time</option>');
                            $.each(response.data,function(key,value){
                                console.log(value.time);
                            $("#time_id").append('<option value="'+value.id+'">'+value.title+' - '+value.class+'x classes - '+value.time+'min'+'</option>');
                            });
                        }
                    }
                    if(response.success==false) {
                        $('#std1').html('Student has not enough credits, Kindly ask to purchase classes.');
                        $("#time_id").empty();
                    }
                }
            });
        });
        $(document).on("change", ".time", function() {
        var c_id = $('#time_id').val();
        var t_id = $('#user_id').val();
        var s_id = $('#std_id').val();
            $.ajax({
                url: "{{ route('admin.cal') }}",
                type: 'GET',
                data: {
                    c_id: c_id,
                    t_id: t_id,
                    s_id: s_id
                },
                dataType: 'json',
                success: function(data) {
                    $("#class_id").val(data.class_id);
                    $("#t_credit").val(data.credit);
                    $('.time-frame').html(data.html);
                    $('#schedule-calendar').modal('show');

                    setTimeout(() => {
                        cal_init_book();
                    }, 800);
                }
            });
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

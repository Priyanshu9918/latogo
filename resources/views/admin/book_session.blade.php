@extends('layouts.admin.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <h5 class="card-header">Booking Sessions</h5>
            @if(Session::has('msg'))
            <div class="alert alert-success" role="alert"><strong>{{ Session::get('msg') }}</strong></div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table example table-light" id="example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Student Name</th>
                            <th>Teacher Name</th>
                            <th>Class Name</th>
                            <th>Duration</th>
                            <th>Student Url</th>
                            <th>Teacher Url</th>
                            <th>Record Url</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            @php $q=1; @endphp
                            @foreach($booking_data as $row)
                            <td>{{ $q++ }}</td>
                            <td>{{ $row?$row->s_name:'--' }}</td>
                            <td>{{ $row?$row->t_name:'--' }}</td>
                            <td>{{ isset($row->title)?$row->title:'' }}/{{ isset($row->totle_class)?$row->totle_class:'' }}x Classes</td>
                            <td>{{ $row->duration}}Min</td>
                            <td><a href="{{$row->student_url}}" class="btn btn-sm btn-success">copy Student Url</a></td>
                            <td><a href="{{$row->teacher_url}}" class="btn btn-sm btn-success">copy Teacher Url</a></td>
                            <td><a href="{{$row->record_url}}" class="btn btn-sm btn-success">copy Record Url</a></td>
                            @php
                                $user1 = DB::table('teacher_settings')->where('user_id',$row->teacher_id)->first();
                                $timezone = DB::table('time_zones')->where('id',$user1->timezone ?? 136)->first();
                                $tz = $timezone->timezone;

                                $time_from  = $row->start_time;
                                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                                $tf_time    = $time_from_t1->format("h:i A");
                                $tf_time_day    = $time_from_t1->format("l");
                                $tf_time_date    = $time_from_t1->format("Y-m-d");
                            @endphp
                            <td>{{ $tf_time_date }}</td>
                            <td>{{ $tf_time_day }}</td>
                            <td>{{ $tf_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endsection

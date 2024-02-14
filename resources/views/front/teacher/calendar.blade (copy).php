@extends('layouts.teacher.master')
@section('content')
        <div class="page-content instructor-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
@push('script')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'UTC',
        dayMaxEvents: true, // allow "more" link when too many events
        events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
      });

      calendar.render();
    });
</script>
@endpush
@endsection

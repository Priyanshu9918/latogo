@extends('layouts.dashboard.master2')
@section('content')
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="breadcrumb-list">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Cancellation Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
		<div class="page-content">
            <div class="axil-checkout-area axil-section-gap">
                <div class="container">
                    <h2 class="text-center">Cancellation Policy Overview:</h2>
                    
                    <ul style="line-height: 35px;">
                        <li>Latogo is not responsible for class credits or refunds for classes booked on incorrect dates or times.</li>
                        <li>Ensure accurate class bookings, especially when traveling across timezones or during regional timezone changes.</li>
                        <li>Live classes must be scheduled at least 24 hours in advance.</li>
                        <li>Teacher cancellations or missed classes:</li>
                            <ul>
                                <li>Full refund for teacher-canceled classes.</li>
                                <li>Full refund available upon request for teacher no-shows or class rescheduling.</li>
                            </ul>
                        <li>Late cancellations (less than 24 hours' notice) result in a loss of credit.</li>
                        <li>Attend the class no later than 10 minutes after the scheduled start time to be marked as attended.</li>
                        <li>It is your responsibility to have a stable internet connection and necessary technical settings (microphone, speakers).</li>
                        <li>Latogo will not refund classes missed due to reasons beyond our control (e.g., health, job, technical issues).</li>
                        <li>Report class issues (teacher no-show or technical errors) within 48 hours for potential refund.</li>
                    </ul>
            </div>
        </div>
    </div>
@endsection

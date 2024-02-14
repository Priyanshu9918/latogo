@extends('layouts.student.master')
@section('content')
<div class="container" style="margin-top:5%; margin-bottom: 49px;">
	<div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000; background-color: azure;">
            <h2 class="text-center" style="margin-top: 19px;">YOUR Payment HAS BEEN RECEIVED</h2>
          <h3 class="text-center">Thank you for your Booking Classes</h3>
          <!-- @php 
            $order_no = session()->get('order_no');
          @endphp -->
          <!-- <p class="text-center">Your order no is: {{$order_no}}</p> -->
            <center><div class="btn-group" style="margin-top:-45px;">
                <a href="{{url('/products')}}" class="btn btn-lg btn-warning">Continue Training</a>
            </div></center>
        </div>
	</div>
</div>
 @endsection

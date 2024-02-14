@extends('layouts.dashboard.master2')
@section('content')
		<div class="page-content">
            <div class="axil-checkout-area axil-section-gap">
                <div class="container">
                @if($data->name  ?? '')
                    <h2 class="text-center">{{$data->name}}</h2>
                @endif
                @if($data->content  ?? '')
                    <p class="w-100">{!!$data->content!!}</p>
                @else
                <span style="margin-left:42%; font-weight: bold;">No Any Policies</span>
                @endif
                
            </div>
        </div>
@endsection

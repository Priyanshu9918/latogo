@extends('layouts.admin.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row" style="margin:0px;">
        <div class="card">
            <h5 class="card-header">Order Details</h5>
            @if(Session::has('msg'))
            <div class="alert alert-success" role="alert"><strong>{{ Session::get('msg') }}</strong></div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table  table-light" id="example">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>COURSES</th>
                            <th>SALES</th>
                            <th>Date</th>
                            <th>Order No</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <?php
                            $name = DB::table('users')->where('id', $order_data->user_id)->first();
                            $order_item = DB::table('order_items')->select(DB::raw('SUM(quantity) as total_item'))->where('order_id', $order_data->id)->first();
                            $order_item1 = DB::table('order_items')->where('order_id', $order_data->id)->get();

                            ?>
                            <td>{{ $name?$name->name:'--' }}</td>

                            <td>
                                @foreach($order_item1 as $order_items1)
                                <?php if (isset($order_items1->class_id)) {
                                    $priceval = DB::table('pricings')->where('id', $order_items1->class_id)->first();
                                    $courses = DB::table('price_masters')->where('id', $priceval->price_master)->first();
                                } ?>
                                <p>{{ isset($courses->title)?$courses->title:'' }}/ {{ isset($priceval->time)?$priceval->time:'' }} min/ {{ isset($priceval->totle_class)?$priceval->totle_class:'' }}x Classes</p>
                                @endforeach
                            </td>
                            <td class="instruct-orders-info">
                                @foreach($order_item1 as $order_items2)
                                <p>{{ $order_items2->quantity }}</p>
                                @endforeach
                            </td>
                            <td>{{$order_data->created_at}}</td>
                            <td>{{$order_data->order_no}}</td>
                            <td>{{ $order_data->total_price }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row pt-5" style="margin:0px;">
            <div class="col">
                <?php
                $address = DB::table('billing_details')->where('user_id', $order_data->user_id)->first();
                $user = DB::table('users')->where('id', $order_data->user_id)->first();

                ?>
                <div class="card" style="height: 250px;">
                    <div class="card-body">
                        <p><b>Name: </b>{{ $user?$user->name:'--' }}</p>
                        <p><b>Address: </b>{{ $address->address }}</p>
                        <p><b>Contact: </b>{{ $user?$user->phone:'--' }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="height: 250px;">
                    <div class="card-body">
                        <p><b>Order ID: </b>#{{ $order_data->id }}</p>
                        <p><b>Order No: </b>{{ $order_data->order_no  }}</p>
                        <p><b>Total: </b>{{ $order_data->total_price }}</p>
                    </div>
                </div>
            </div>
            @endsection

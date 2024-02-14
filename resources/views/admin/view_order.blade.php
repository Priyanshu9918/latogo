@extends('layouts.admin.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <h5 class="card-header">Orders</h5>
            @if(Session::has('msg'))
            <div class="alert alert-success" role="alert"><strong>{{ Session::get('msg') }}</strong></div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table example table-light" id="example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Student Name</th>
                            <th>COURSES</th>
                            <th>SALES</th>
                            <th>Date</th>
                            <th>Order No</th>
                            <th>Total</th>
                            <th>View details</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            @php $q=1; @endphp
                            @foreach($order_data as $row)
                            <?php
                            $name = DB::table('users')->where('id', $row->user_id)->first();
                            $order_item = DB::table('order_items')->select(DB::raw('SUM(quantity) as total_item'))->where('order_id', $row->id)->first();
                            $order_item1 = DB::table('order_items')->where('order_id', $row->id)->get();
                            ?>
                            <td>{{ $q++ }}</td>
                            <td>{{ $name?$name->name:'--' }}</td>
                            <td>
                                @foreach($order_item1 as $order_items1)
                                <?php if (isset($order_items1->class_id)) {
                                   
                                    $time = DB::table('pricings')->where('id', $order_items1->class_id)->first();
                                    $courses = DB::table('price_masters')->where('id', $time->price_master)->first();
                                } ?>
                                <p>{{ isset($courses->title)?$courses->title:'' }}/ {{ isset($time->time)?$time->time:'' }} min/ {{ isset($time->totle_class)?$time->totle_class:'' }}x Classes</p>
                                @endforeach
                            </td>
                            <td class="instruct-orders-info">
                                @foreach($order_item1 as $order_items2)
                                <p>{{ $order_items2->quantity }}</p>
                                @endforeach
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->order_no }}</td>
                            <td>{{ $row->total_price }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow">
                                        <a class="dropdown-item text-success" href="{{ url('admin/order_details',['id'=>$row->id]) }}"><i class="bx bx-show-alt me-1"></i></a>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endsection

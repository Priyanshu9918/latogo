@extends('layouts.dashboard.master2')
@section('content')
<style>
    .modal-ku {
        width: 1000px;
        margin: auto;
        }
        .faq-card {
            margin-bottom: 15px !important;
        }

        .product-img {
            max-width: 100px;
        }

        .ds-mw-100 {
            max-width: 100px;
        }

        td {
            vertical-align: middle;
        }

        .check-outs {
            width: 230px;
            margin-right: 0;
            margin-left: auto;
        }
		.fs-22{
			    font-size: 22px !important;
		}
        .stripe-connect {
            background: #635bff;
            display: inline-block;
            height: 40px;
            text-decoration: none;
            width: 375px;

            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;

            user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;

            -webkit-font-smoothing: antialiased;
            max-width: 100%;
            }

            .stripe-connect span {
                color: #ffffff;
            display: block;
            font-family: sohne-var, "Helvetica Neue", Arial, sans-serif;
            font-size: 15px;
            font-weight: 400;
            line-height: 14px;
            padding: 13px 0px 0px 85px;
            position: relative;
            text-align: left;
            }

            .stripe-connect:hover {
            background: #7a73ff;
            }

            .stripe-connect.slate {
            background: #0a2540;
            }

            .stripe-connect.slate:hover {
            background: #425466;
            }

            .stripe-connect.white {
            background: #ffffff;
            }

            .stripe-connect.white span {
            color: #0a2540;
            }

            .stripe-connect.white:hover {
            background: #f6f9fc;
            }

            .stripe-connect span::after {
                background-repeat: no-repeat;
                background-size: 49.58px;
                content: "";
                height: 20px;
                left: 56%;
                position: absolute;
                top: 30.95%;
                width: 49.58px;
            }

            /* Logos */
            /* .stripe-connect span::after {
            background-image: url("data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!-- Generator: Adobe Illustrator 23.0.4, SVG Export Plug-In . SVG Version: 6.00 Build 0) --%3E%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 468 222.5' style='enable-background:new 0 0 468 222.5;' xml:space='preserve'%3E%3Cstyle type='text/css'%3E .st0%7Bfill-rule:evenodd;clip-rule:evenodd;fill:%23FFFFFF;%7D%0A%3C/style%3E%3Cg%3E%3Cpath class='st0' d='M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3 c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z'/%3E%3Cpath class='st0' d='M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3 c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1 c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z'/%3E%3Cpolygon class='st0' points='223.8,61.7 248.9,56.3 248.9,36 223.8,41.3 '/%3E%3Crect x='223.8' y='69.3' class='st0' width='25.1' height='87.5'/%3E%3Cpath class='st0' d='M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z'/%3E%3Cpath class='st0' d='M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135 c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z'/%3E%3Cpath class='st0' d='M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6 C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7 c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z'/%3E%3C/g%3E%3C/svg%3E");
            }

            .stripe-connect.white span::after {
            background-image: url("data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!-- Generator: Adobe Illustrator 24.0.3, SVG Export Plug-In . SVG Version: 6.00 Build 0) --%3E%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 468 222.5' style='enable-background:new 0 0 468 222.5;' xml:space='preserve'%3E%3Cstyle type='text/css'%3E .st0%7Bfill-rule:evenodd;clip-rule:evenodd;fill:%230A2540;%7D%0A%3C/style%3E%3Cg%3E%3Cpath class='st0' d='M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3 c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z'/%3E%3Cpath class='st0' d='M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3 c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1 c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z'/%3E%3Cpolygon class='st0' points='223.8,61.7 248.9,56.3 248.9,36 223.8,41.3 '/%3E%3Crect x='223.8' y='69.3' class='st0' width='25.1' height='87.5'/%3E%3Cpath class='st0' d='M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z'/%3E%3Cpath class='st0' d='M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135 c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z'/%3E%3Cpath class='st0' d='M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6 C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7 c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z'/%3E%3C/g%3E%3C/svg%3E");
            } */

            /* Please remove from your implementation. Used to display the white button on the white background */
            .stripe-connect.white {
            left: 1px;
            position: relative;
            top: 1px;
            }

            /* Please remove from your implementation. Used to display the white button on the white background */
    </style>
    <div class="pre-loader" style="display: block;"></div>
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="breadcrumb-list">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                    <li class="breadcrumb-item">Cart</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="course-content checkout-widget">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">

                        <div class="student-widget">
                            <div class="student-widget-group add-course-info">
                                <div class="cart-head">
                                    <h4>Billing Address</h4>
                                </div>
                                <div class="checkout-form">
                                <form action="{{route('student.add.checkout')}}" method="POST" id="createFrm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="hidden" id="bill_id" name="bill_id" value="{{$billing->id ?? ''}}">
                                                <div class="form-group">
                                                    <label class="form-control-label">Full Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your first Name" name="first_name" id="first_name" value="{{$billing->first_name ?? Auth::user()->name}}">
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-first_name"></p>

                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Last Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter your last Name" name="last_name" id="last_name" value="{{$billing->last_name ?? ''}}">
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-last_name"></p>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="{{$billing->phone_no ?? Auth::user()->phone}}">
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                @php 
                                                    $std = DB::table('student_details')->where('user_id',Auth::user()->id)->first();
                                                @endphp
                                                <div class="form-group">
                                                    <label class="form-control-label">Address Line 1</label>
                                                    @if(isset($std->address1))
                                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{$billing->address ?? $std->address1}}">
                                                    @else
                                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{$billing->address ?? ''}}">
                                                    @endif
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-address"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label">Country</label>
                                                    <select class="form-select country" name="country" id="country_id">
                                                    <option value="" >Select country</option>
                                                    @foreach($countries as $country)
                                                        @if(isset($std->country))
                                                                <option value="{{ $country->id }}" @if($country->id == $std->country ?? 101) selected="" @endif >{{ $country->name }}</option>
                                                        @else
                                                            @if(isset($billing->country))
                                                                <option value="{{ $country->id }}" @if($country->id == $billing->country ?? 101) selected="" @endif >{{ $country->name }}</option>
                                                            @else
                                                                <option value="{{ $country->id }}" >{{ $country->name }}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-country"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label">State</label>
                                                    <select class="form-select select state" name="state" id="state_id">
                                                    <option value="" >Select state</option>
                                                    @foreach($state as $states)
                                                        @if(isset($std->state))
                                                            <option value="{{ $states->id }}" @if($states->id == $std->state ?? 101) selected="" @endif >{{ $states->name }}</option>
                                                        @else
                                                            @if(isset($billing->state))
                                                                <option value="{{ $states->id }}" @if($states->id == $billing->state) selected="" @endif >{{ $states->name }}</option>
                                                            @else
                                                                <option value="{{ $states->id }}">{{ $states->name }}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-state"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Zip/Postal Code</label>
                                                    @if(isset($std->country))
                                                        <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{$billing->postal_code ?? $std->postal_code}}">
                                                    @else
                                                        <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{$billing->postal_code ?? ''}}">
                                                    @endif
                                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-postal_code" ></p>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-12 col-lg-10">
                                                <div class="form-group ship-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="remember" value="1" checked>
                                                    Save this information for next time
                                                </div>
                                            </div> -->
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="student-widget pay-method d-none">
                            <div class="student-widget-group add-course-info">
                                <div class="cart-head">
                                    <h4>Payment Method</h4>
                                </div>
                                <div class="checkout-form">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="wallet-method">
                                                    <label class="radio-inline custom_radio me-4">
                                                        <input type="radio" name="optradio" checked="">
                                                        <span class="checkmark"></span> Credit or Debit card
                                                    </label>
                                                    <label class="radio-inline custom_radio">
                                                        <input type="radio" name="optradio">
                                                        <span class="checkmark"></span> PayPal
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Card Number</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="XXXX XXXX XXXX XXXX">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label">Month</label>
                                                    <select class="form-select select" name="sellist1">
                                                        <option>Month</option>
                                                        <option>Jun</option>
                                                        <option>Feb</option>
                                                        <option>March</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label">Year</label>
                                                    <select class="form-select select" name="sellist1">
                                                        <option>Year</option>
                                                        <option>2022</option>
                                                        <option>2021</option>
                                                        <option>2020</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">CVV Code </label>
                                                    <input type="text" class="form-control" placeholder="XXXX">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Name on Card</label>
                                                    <input type="text" class="form-control" placeholder="Address">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-10">
                                                <div class="form-group ship-check">
                                                    <input class="form-check-input" type="checkbox" name="remember">
                                                    Remember this card
                                                </div> 
                                            </div>
                                            <div class="payment-btn">
                                                <button class="btn btn-primary " style="min-width: auto;" type="submit">Make a Payment</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $ref_user111 = DB::table('referal_data_amount_new')->where('ref_rec_id',Auth::user()->id)->first();
                        @endphp

                    </div>
                    <div class="col-lg-4 theiaStickySidebar">
                        <div class="student-widget select-plan-group">
                            <div class="student-widget-group">
								<h4 class="mb-4">Your order</h4>
								<div class="input-group mb-3">
                                    @if(isset(Session::get('coupan')['key']) && Session::get('coupan')['key']== Auth::user()->id)
                                    <a href="javascript:void(0)" id="remove"><i class="fa fa-times" style="color: red;position: relative;top: 13px;right: 9px;}"></i></a> <input type="text" class="form-control" placeholder="Enter coupon here" id="coupan" value="{{Session::get('coupan')['coupan_code']}}" readonly>
                                    @else
                                        @if(isset($ref_user111) && $ref_user111->status == 0)
                                        @else
                                            <input type="text" class="form-control" placeholder="Enter coupon here" id="coupan">
                                            <button class="btn btn-primary cpn" style=" background: #ff5364;" type="button">Apply</button>
                                        @endif
                                    @endif
								</div>
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="cpn_error"></p>
								<div class="wallet-method">
									<!-- <label class="radio-inline custom_radio me-4">
										<input type="radio" name="optradio" checked="">
										<span class="checkmark"></span> Credit or Debit card
									</label> -->
									<!-- <label class="radio-inline custom_radio">
										<input type="radio" name="optradio" checked="">
										<span class="checkmark"></span> PayPal
									</label> -->
								</div>
								<div class="benifits-feature">
                                @php 
                                    $new_user = DB::table('orders')->where('user_id',Auth::user()->id)->where('is_completed',1)->get();
                                    $price = DB::table('pricings')->where('price_master',1)->where('time',45)->where('totle_class',1)->first();
                                    $ref_user = DB::table('referal_data_amount_new')->where('ref_rec_id',Auth::user()->id)->first();
                                @endphp
                                    @if(isset($ref_user111) && $ref_user->status == 0)
                                        <div class="d-flex justify-content-between mb-3">
                                            <h3 class="m-0">Subtotal</h3>
                                            @if(Session::get('currency') == 'EUR')
                                            <h3 class="m-0">€ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3>
                                            @else
                                            <h3 class="m-0">$ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3>
                                            @endif
                                            <!-- <h3 class="m-0">$ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3> -->
                                            <input type="hidden" name="sub_total" value="{{\Cart::session(Auth::user()->id)->getSubTotal()}}">
                                        </div>
                                        @php 
                                            $items = \Cart::getContent();
                                        @endphp
                                        @if(isset($items[$price->id]))
                                            @if($price->total_price <= \Cart::session(Auth::user()->id)->getSubTotal())
                                            <p style="color:red;">Applied: 45-minute trial class at 5 $ instead of 35$</p>
                                            <div class="d-flex justify-content-between mb-3">
                                                <h3 class="m-0 fs-22">Total</h3>
                                                @if(Session::get('currency') == 'EUR')
                                                <h3 class="m-0 fs-22">€ {{(\Cart::session(Auth::user()->id)->getSubTotal() + 5) - $price->total_price}}.00</h3>
                                                @else
                                                <h3 class="m-0 fs-22">$ {{(\Cart::session(Auth::user()->id)->getSubTotal() + 5) - $price->total_price}}.00</h3>
                                                @endif
                                                <input type="hidden" id="total_price" name="total_price" value="{{\Cart::session(Auth::user()->id)->getSubTotal() - $price->total_price + 5}}">
                                                <input type="hidden" name="discount" value="{{$price->total_price - 5}}">
                                            </div> 
                                            @endif
                                        @else
                                            <p style="color:red;">Please Add 45 min class to take trial offer benefits .</p>
                                            <div class="d-flex justify-content-between mb-3">
                                                <h3 class="m-0 fs-22">Total</h3>
                                                @if(Session::get('currency') == 'EUR')
                                                <h3 class="m-0 fs-22">€ {{\Cart::session(Auth::user()->id)->getTotal()}}.00</h3>
                                                @else
                                                <h3 class="m-0 fs-22">$ {{\Cart::session(Auth::user()->id)->getTotal()}}.00</h3>
                                                @endif
                                                <input type="hidden" id="total_price" name="total_price" value="{{\Cart::session(Auth::user()->id)->getTotal()}}">
                                            </div>
                                        @endif
                                    @else
                                        @if(isset(Session::get('coupan')['key']) && Session::get('coupan')['key']== Auth::user()->id)
                                        <div class="d-flex justify-content-between mb-3">
                                            <h3 class="m-0">Subtotal</h3>
                                            @if(Session::get('currency') == 'EUR')
                                            <h3 class="m-0">€ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3>
                                            @else
                                            <h3 class="m-0">$ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3>
                                            @endif
                                            <!-- <h3 class="m-0">$ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3> -->
                                            <input type="hidden" name="sub_total" value="{{\Cart::session(Auth::user()->id)->getSubTotal()}}">
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h3 class="m-0">Discount</h3>
                                            @if(Session::get('currency') == 'EUR')
                                            <h3 class="m-0">€ {{Session::get('coupan')['discount']}}.00</h3>
                                            @else
                                            <h3 class="m-0">$ {{Session::get('coupan')['discount']}}.00</h3>
                                            @endif
                                            <input type="hidden" name="discount" value="{{Session::get('coupan')['discount']}}">
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h3 class="m-0 fs-22">Total</h3>
                                            @if(Session::get('currency') == 'EUR')
                                            <h3 class="m-0 fs-22">€ {{Session::get('coupan')['total']}}.00</h3>
                                            @else
                                            <h3 class="m-0 fs-22">$ {{Session::get('coupan')['total']}}.00</h3>
                                            @endif
                                            <input type="hidden" id="total_price" name="total_price" value="{{Session::get('coupan')['total']}}">
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between mb-3">
                                            <h3 class="m-0">Subtotal</h3>
                                            <!-- <h3 class="m-0">$ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3> -->
                                            @if(Session::get('currency') == 'EUR')
                                            <h3 class="m-0">€ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3>
                                            @else
                                            <h3 class="m-0">$ {{\Cart::session(Auth::user()->id)->getSubTotal()}}.00</h3>
                                            @endif
                                            <input type="hidden" name="sub_total" value="{{\Cart::session(Auth::user()->id)->getSubTotal()}}">
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h3 class="m-0 fs-22">Total</h3>
                                            @if(Session::get('currency') == 'EUR')
                                            <h3 class="m-0 fs-22">€ {{\Cart::getTotal()}}.00</h3>
                                            @else
                                            <h3 class="m-0 fs-22">$ {{\Cart::getTotal()}}.00</h3>
                                            @endif
                                            <!-- <h3 class="m-0 fs-22">$ {{\Cart::getTotal()}}.00</h3> -->
                                            <input type="hidden" id="total_price" name="total_price" value="{{\Cart::session(Auth::user()->id)->getTotal()}}">
                                        </div>
                                    @endif
                                @endif
								</div>
                                @php
                                    $data = Helper::getcartList();
                                @endphp
                                @foreach ($data as $item)
                                        <input type="hidden" id="quantity" name="quantity[]" value="{{$item->quantity}}">
                                        <input type="hidden" id="product_id" name="product_id[]" value="{{$item->id}}">
                                        <input type="hidden" id="price" name="price[]" value="{{Cart::get($item->id)->getPriceSum()}}">
                                        <input type="hidden" id="base_price" name="base_price[]" value="{{$item->price}}">
                                    @endforeach
                                <div class="payment-btn">
                                    @if(\Cart::getTotal() == 0)
                                        <p style="color:red;font-weight: bold;">Your Cart Is Empty!</p>
                                    @else
									<button class="btn btn-primary w-100" style="min-width: auto;" id="data12" type="submit">Make a Payment</button>
                                    @endif
                                    <div class="d-none" id="paypal-course-button"></div>
                                    <a href="#" class="stripe-connect d-none" id="stripe"><span style="font-weight:bold;">Pay with credit / debit card </span></a>
								</div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </section>
    <div class="modal fade" id="requestpop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="support-wrap">
                        <h5>Submit a Request</h5>
                        <form action="#">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="Enter your first Name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Enter your email address">
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control" placeholder="Enter your Subject">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Write down here" rows="4"></textarea>
                            </div>
                            <button class="btn btn-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
            <div class="modal-content" style="height:650px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Stripe Payment</h5>
            </div>
            <div class="modal-body">
            <main>
                <div class="row">
                    <aside class="col-sm-6 offset-3">
                        <article class="card">
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error1"></p>
                            <div class="card-body p-5">
                                <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#nav-tab-card">
                                        <i class="fa fa-credit-card"></i> Credit Card / Debit Card</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-tab-card">
                                            <div class="form-group">
                                                <label for="username">Full name (on the card)</label>
                                                <input type="text" class="form-control" name="fullName" placeholder="Full Name">
                                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-fullName"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="cardNumber">Card number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="cardNumber" placeholder="Card Number">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted">
                                                        <i class="fab fa-cc-visa fa-lg pr-1"></i>
                                                        <i class="fab fa-cc-amex fa-lg pr-1"></i>
                                                        <i class="fab fa-cc-mastercard fa-lg"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-cardNumber"></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label><span class="hidden-xs">Expiration</span> </label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="month">
                                                                <option value="">MM</option>
                                                                @foreach(range(1, 12) as $month)
                                                                    <option value="{{$month}}">{{$month}}</option>
                                                                @endforeach
                                                            </select>
                                                            <select class="form-control" name="year">
                                                                <option value="">YYYY</option>
                                                                @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                                    <option value="{{$year}}">{{$year}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-year"></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label data-toggle="tooltip" title=""
                                                            data-original-title="3 digits code on back side of the card">CVV <i
                                                            class="fa fa-question-circle" title='The CVV number, or Card Verification Value, is a 3 digit code located on the back of the debit card and is used to complete online transactions.' ></i></label>
                                                        <input type="number" class="form-control" placeholder="CVV" name="cvv">
                                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-cvv"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="subscribe btn btn-primary btn-block" type="submit"> Confirm </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </aside>
                </div>
            </main>
            </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&locale=en_US&components=messages,buttons&disable-funding=card"></script>
<script type="text/javascript">
        $(document).ready(function(){
        $('.pre-loader').hide();
        //on change country
        $(document).on('click','#remove',function(){
            var coupan_code = $('#coupan').val();
            $.ajax({
                url: '{{url('/student/remove')}}',
                type: 'post', 
                dataType: 'json',
                data: {_token:'{{csrf_token()}}',coupan_code:coupan_code},
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        location.reload();
                    }
                },
                error: function (response) {
                        // alert("Error: " + errorThrown);
                    console.log(response);
                }
            });
        });
        $(document).on('click','.cpn',function(){
            var coupan_code = $('#coupan').val();
            if(coupan_code == ''){
                $('#cpn_error').html('Please enter coupon code');
                return false;
            }
            $.ajax({
                url: '{{url('/student/coupan')}}',
                type: 'post', 
                dataType: 'json',
                data: {_token:'{{csrf_token()}}',coupan_code:coupan_code},
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        $("tr").removeClass("coupan_id");
                        $('.coupan-val').html(data.coupan_val);
                        $('#cpn_code').val(data.coupan_cd);
                        $('.total').html(data.total);
                        $('#cpn_error').html('');
                        location.reload();
                    }
                    if (data.status == false)
                    {
                        $('#cpn_error').html(data.msg);
                        // location.reload();
                    }

                },
                error: function (response) {
                        // alert("Error: " + errorThrown);
                    console.log(response);
                }
            });

        });

        $(document).on('click','#stripe',function(){
            $('#exampleModalCenter').modal('show');
        });
        $(document).on('click','.subscribe',function(){
            // $('#exampleModalCenter').modal('show');
            $('p.error_container').html("");
            var formData = new FormData($('#createFrm')[0]);
            $('.pre-loader').show();
            $.ajax({
                type:"post",
                    url:"{{route('student.stripe.post')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    //console.log(response);
                    window.setTimeout(function(){
                        $('.submit').attr('disabled',false);
                        $('.form-control').attr('readonly',false);
                        $('.form-control').removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');
                        $('.submit').html('Save');
                      },2000);
                    if(response.success==true) {
                        $('.pre-loader').hide();

                            toastr.success("Payment created Successfully");

                            // Swal.fire({
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: 'Payment Created Successfully',
                            //     showConfirmButton: false,
                            //     timer: 1500
                            // })
                            window.setTimeout(()=>{
                                window.location.href = "{{url('/student/student-my-order')}}";
                            },1000);
                    }
                    //show the form validates error
                    if(response.success==false ) {
                        $('#error1').html(response.errors);
                        for (control in response.errors) {
                           var error_text = control.replace('.',"_");
                           $('#error-'+error_text).html(response.errors[control]);
                           // $('#error-'+error_text).html(response.errors[error_text][0]);
                           // console.log('#error-'+error_text);
                        $('.pre-loader').hide();
                        }
                        // console.log(response.errors);
                    }
                },
                error: function (response) {
                    // alert("Error: " + errorThrown);
                    console.log(response);
                }
            });
            event.stopImmediatePropagation();
            return false;
        });

        $(document).on('change','.country',function(){
            var id = $('#country_id').val();
            $.ajax({
                    type:"post",
                    url:"{{route('state-list')}}",
                    data:{'country_id':id,"_token": "{{ csrf_token() }}"},
                    success:function(data)
                    {
                        $("#state_id").empty();
                        $("#state_id").html('<option value="">Select State</option>');
                        $.each(data,function(key,value){
                        $("#state_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                });
        });

        // on change state
        $(document).on('change','.state',function(){
            var id = $('#state_id').val();
            $.ajax({
                    type:"post",
                    url:"{{route('city-list')}}",
                    data:{'state_id':id,"_token": "{{ csrf_token() }}"},
                    success:function(data)
                    {
                        $("#city_id").empty();
                        $("#city_id").html('<option value="">Select City</option>');
                        $.each(data,function(key,value){
                            $("#city_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }

                });
        });


        
        $(document).on('submit', 'form#createFrm', function (event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled',true);
            // $('.form-control').attr('readonly',true);
            // $('.form-control').addClass('disabled-link');
            $('.error-control').addClass('disabled-link');
            if ($('.submit').html() !== loadingText) {
                $('.submit').html(loadingText);
            }
            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    //console.log(response);
                    if(response.success==true) {
                        $('#data12').addClass('d-none');
                        $('#paypal-course-button').removeClass('d-none');
                        $('#stripe').removeClass('d-none');
                        $('#first_name').attr('readonly', 'readonly');
                        $('#last_name').attr('readonly', 'readonly');
                        $('#phone').attr('readonly', 'readonly');
                        $('#address').attr('readonly', 'readonly');
                        $('#country_id').attr('readonly', 'readonly');
                        $('#state_id').attr('readonly', 'readonly');
                        $('#postal_code').attr('readonly', 'readonly');
                        
                    }
                    //show the form validates error
                    if(response.success==false ) {
                        for (control in response.errors) {
                           var error_text = control.replace('.',"_");
                           $('#error-'+error_text).html(response.errors[control]);
                           // $('#error-'+error_text).html(response.errors[error_text][0]);
                           // console.log('#error-'+error_text);
                        }
                        // console.log(response.errors);
                    }
                },
                error: function (response) {
                    // alert("Error: " + errorThrown);
                    console.log(response);
                }
            });
            event.stopImmediatePropagation();
            return false;
        });

 

 var purchase_units = [];
 //var order_id = 'ss';
 paypal.Buttons({
    style: {
       layout: 'vertical',
       color:  'white',
       shape:  'pill',
       label:  ''
    },
        //od_create = false;
        createOrder: function() {
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var address = $('#address').val();
            var country = $('#country_id').val();
            var state = $('#state_id').val();
            var postal_code = $('#postal_code').val();
            
            var quantity = $('#quantity').val();
            var product_id = $('#product_id').val();
            var price = $('#price').val();
            var base_price = $('#base_price').val();
            var total_price = $('#total_price').val();


            // let formData = new FormData();
            var formData = new FormData($('#createFrm')[0]);
            // formData.append('_token', "{{csrf_token()}}");
            // formData.append('first_name', first_name);
            // formData.append('last_name', last_name);
            // formData.append('address', address);
            // formData.append('country', country);
            // formData.append('state', state);
            // formData.append('postal_code', postal_code);

            // formData.append('quantity', quantity);
            // formData.append('product_id', product_id);
            // formData.append('price', price);
            // formData.append('base_price', base_price);
            // formData.append('total_price', total_price);


                return fetch(
                        "{{url('student/paypal-course-order-create1')}}",
                        {
                        method: 'POST',
                        // headers: {
                        //    'X-CSRFToken': "{{csrf_token()}}"
                        // },
                        body: formData
                        }
                    ).then(function(response) {
                        return response.json();
                    }).then(function(resJson) {
                        console.log('Order ID: '+ resJson.data.id);
                        return resJson.data.id;
                    });

                    //return od_create;
        },
        // Wait for the payment to be authorized by the customer
        onApprove: function(data, actions) {
            let formData = new FormData();
            formData.append('_token', "{{csrf_token()}}");
            return fetch(
                "{{url('student/paypal-order-capture1')}}",
                {
                    method: 'POST',
                    body: formData
                }
            ).then(function(res) {
                return res.json();
            }).then(function(res) {
                if(res.data.hasOwnProperty('status') && res.data.status=='COMPLETED')
                {
                    toastr.success("Payment created Successfully");

                    // Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'Payment Created Successfully',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // })
                    window.setTimeout(()=>{
                        window.location.href = "{{url('/student/student-my-order')}}";
                    },1000);
                }
                else
                {
                    alert('Due to some error please try again.');
                }
            });
        }

    }).render('#paypal-course-button');
    });
    </script>
@endpush
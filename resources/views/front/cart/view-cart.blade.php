@extends('layouts.dashboard.master2')
@section('content')
<style>
    .faq-card {
        margin-bottom: 15px !important;
    }
    .product-img{
        max-width:100px;
    }
    .ds-mw-100{
        max-width:100px;
    }
    td{
        vertical-align: middle;
    }
    .check-outs{
        width: 230px;
        margin-right: 0;
        margin-left: auto;
    }
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
        <section class="course-content cart-widget">
            <div class="container">
                <div class="student-widget">
                    <div class="student-widget-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-head">
                                    <h4>Your cart ({{Cart::getTotalQuantity()}} items)</h4>
                                </div>
                                <div class="cart-group">
                                    <div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
											<table class="table">
											  <thead>
												<tr>
												  <th></th>
												  <th scope="col">Class Type</th>
												  <th scope="col">Price</th>
												  <th scope="col">Quantity</th>
												  <th scope="col">Subtotal</th>
												</tr>
											  </thead>
											  <tbody>
                                              <form action="{{url('student/update-cart')}}" method="post" id="quant">
                                                @csrf
                                              @foreach ($cartItems as $item)
												<tr>
                                                    <input type="hidden" id="class_id" name="class_id" value="">
                                                <td class="product-remove"><a href="{{route('student.cart.remove',['id'=>$item->id])}}" class="remove-wishlist"><i class="fa fa-times"></i></a></td>
                                                @php
                                                    $single = Helper::getSingleProduct($item->id);
                                                    $cartitem=Cart::session(Auth::user()->id)->get($item->id);
                                                @endphp
                                                @foreach($single as $items)
													<td>
														<h5 class="title">
                                                        {{$items->totle_class}}x Classes
														</h5>
													</td>
                                                  <input type="hidden" id="id" name="id[]" value="{{$item->id}}">
												  <!-- <td><h4 class="title">$ {{$items->total_price}} <h4></td>
												  <td><input type="number" name="quantity[]" id="quantity" value="{{$cartitem->quantity}}" class="form-control ds-mw-100"  placeholder=""></td>
												  <td><h4 class="title">$ {{Cart::get($item->id)->getPriceSum()}}<h4></td> -->
                                                    @if(Session::get('currency') == 'EUR')
                                                        @php
                                                            $total_price = Helper::currency($items->total_price);
                                                        @endphp
                                                        <td><h4 class="title">€ {{$total_price}} <h4></td>
                                                    @else
                                                    <td><h4 class="title">$ {{$items->total_price}} <h4></td>
                                                    @endif
												    <td><input type="number" name="quantity[]" id="quantity" value="{{$cartitem->quantity}}" class="form-control ds-mw-100"  placeholder=""></td>
                                                    @if(Session::get('currency') == 'EUR')
                                                        <td><h4 class="title">€ {{Cart::get($item->id)->getPriceSum()}}<h4></td>
                                                    @else
                                                        <td><h4 class="title">$ {{Cart::get($item->id)->getPriceSum()}}<h4></td>
                                                    @endif
                                                  @endforeach
												</tr>
                                                @endforeach
											</table>
                                            </form>
                                            </tbody>
                                              <div class="check-outs">
                                                    <a class="btn btn-primary w-auto" id="cart">Update Cart</a>
                                                </div>
											</div>
										</div>
                                    </div>
                                </div>
                                <form action="{{url('student/checkout')}}" method="get" id="quant1">
                                @csrf
                                    <div class="cart-total">
                                        <div class="row justify-content-end">
                                            <div class="col-md-3">
                                                <div class="cart-subtotal">
                                                    <!-- <p class="justify-content-between">Subtotal : <span class="ms-2">$ {{\Cart::getSubTotal()}}.00</span></p> -->
                                                    @if(Session::get('currency') == 'EUR')
                                                        <p class="justify-content-between">Subtotal : <span class="ms-2">€ {{\Cart::getSubTotal()}}.00</span></p>
                                                    @else
                                                        <p class="justify-content-between">Subtotal : <span class="ms-2">$ {{\Cart::getSubTotal()}}.00</span></p>
                                                    @endif
                                                </div>
                                                <div class="cart-subtotal">
                                                    @if(Session::get('currency') == 'EUR')
                                                        <p class="justify-content-between">Total : <span class="ms-2">€     {{\Cart::getTotal()}}.00</span></p>
                                                    @else
                                                        <p class="justify-content-between">Total : <span class="ms-2">$     {{\Cart::getTotal()}}.00</span></p>
                                                    @endif
                                                    <!-- <p class="justify-content-between">Total : <span class="ms-2">$     {{\Cart::getTotal()}}.00</span></p> -->
                                                </div>
                                                <div class="check-outs w-100">
                                                    <a href="javascript:void(0)" class="btn btn-primary" id="checkout" onclick="submitForms()">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.pre-loader').hide();
        });
        $(document).on('click','#cart',function(){
            var quantity = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
            var id = $("input[name='id[]']").map(function(){return $(this).val();}).get();
            $('.pre-loader').show();
            $.ajax({
                url: "{{ url('student/update-cart') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'quantity': quantity,
                    'id': id,
                },
                success: function(response) {
                    if(response.success == true){
                        window.setTimeout(function() {
                            window.location.href = "{{ url('/')}}"+"/student/cart-list";
                        }, 2000);              
                    }
                }
            });
        });
        $(document).on('click','#checkout',function(){
            var quantity = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
            var id = $("input[name='id[]']").map(function(){return $(this).val();}).get();
            $('.pre-loader').show();
            $.ajax({
                url: "{{ url('student/update-cart') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'quantity': quantity,
                    'id': id,
                },
                success: function(response) {
                    if(response.success == true){
                        window.setTimeout(function() {
                            document.getElementById('quant1').submit();
                        }, 2000);              
                    }
                }
            });
        });
    </script>
    @endpush


        @if($price)
        @foreach($price as $price1)
        @if(Auth::user() && Auth::user()->user_type == 2)
        <div class="plan-box py-2 dash">
        @else
        <div class="plan-box py-2 dash" onclick="Cart({{$price1->id}})">
        @endif
        @if($price1->popular == 1)
        <span class="most-popular">Most popular</span>
        @endif
            <!-- <div>
                <h4>{{$price1->totle_class}}x Classes</h4>
                <p>Total : <b>${{$price1->total_price}}</b></p>
            </div>
            <h3><span>$</span>{{$price1->price}}<span>/ Class</span></h3> -->
            @if(Session::get('currency') == 'EUR')
                @php
                    $total_price = Helper::currency($price1->total_price);
                    $price = Helper::currency($price1->price);

                @endphp
                <div>
                    <h4>{{$price1->totle_class}}x Classes</h4>
                    <p>Total : <b>€{{$total_price}}</b></p>
                </div>
                <h3><span>€</span>{{$price}}<span>/ Class</span></h3>
            @else
                <div>
                    <h4>{{$price1->totle_class}}x Classes</h4>
                    <p>Total : <b>${{$price1->total_price}}</b></p>
                </div>
                <h3><span>$</span>{{$price1->price}}<span>/ Class</span></h3>
            @endif
        </div>
        @endforeach
        @else
        <h1>No Data Found</h1>
        @endif

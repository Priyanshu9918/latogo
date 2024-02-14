@extends('layouts.dashboard.master2')
@section('content')
<div class="pre-loader" style="display: block;"></div>
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="breadcrumb-list">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item gg">Pricing</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="course-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="title-sec aos" data-aos="fade-up">
                    <h2>Get ready for flexible and convenient language learning</h2>
                    <div class=" py-2 d-flex align-items-center flex-wrap">
                        <div class="award-list d-flex align-items-center">
                            <span class="award-icon">
                                <img src="assets/img/icon-three/check-round-2.svg" alt="" class="img-fluid">
                            </span>
                            <p class="m-0">Easy scheduling 24/7</p>
                        </div>
                        <div class="award-list d-flex align-items-center">
                            <span class="award-icon">
                                <img src="assets/img/icon-three/check-round-2.svg" alt="" class="img-fluid">
                            </span>
                            <p class="m-0">Individual</p>
                        </div>
                        <div class="award-list d-flex align-items-center">
                            <span class="award-icon">
                                <img src="assets/img/icon-three/check-round-2.svg" alt="" class="img-fluid">
                            </span>
                            <p class="m-0">Efficient</p>
                        </div>
                        <div class="award-list d-flex align-items-center">
                            <span class="award-icon">
                                <img src="assets/img/icon-three/check-round-2.svg" alt="" class="img-fluid">
                            </span>
                            <p class="m-0">Goal-orientated</p>
                        </div>
                    </div>
                </div>
                <div class="row" id="tab">
                    @php
                    $price_master = Helper::getPriceMaster();
                    @endphp
                    @if($price_master)
                    @foreach($price_master as $key => $p_master)
                    <div class="col-md-12 col-6">
                        @if($key == 0)
                        
                        <div class="plan-box justify-content-center cl blue{{$key}} active" data-key="{{$key}}" data-aos="fade-up" id="ac{{$p_master->id}}" onclick="pricing({{$p_master->id}})">
                            @else
                            <div class="plan-box justify-content-center cl blue{{$key}}" data-key="{{$key}}" data-aos="fade-up" id="ac{{$p_master->id}}" onclick="pricing({{$p_master->id}})">
                                @endif
                                <div class="d-flex">
                                    <img src="{{asset('uploads/price/'.$p_master->icon)}}" class="icon-img me-3" alt="" />
                                    <div class="">
                                        <h4 class="headline">{{$p_master->title}}</h4>
                                        <p class="para text-start">{{$p_master->short_title}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h1>No Data Found</h1>
                        @endif
                        {{--<div class="col-md-4">
                                <div class="plan-box active" data-aos="fade-up" onclick="changePrice('partner', this)">
                                    <div>
                                        <img src="assets/img/partner.png" class="icon-img" alt="" />
                                        <h4 class="headline">Partner 2:1</h4>
                                        <p class="para">Nulla hendrerit cursus orci fermentum facilisis.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="plan-box lblue" data-aos="fade-up" onclick="changePrice('team', this)">
                                    <div>
                                        <img src="assets/img/team.png" class="icon-img" alt="" />
                                        <h4 class="headline">Team 4:1</h4>
                                        <p class="para">Nulla hendrerit cursus orci fermentum facilisis.</p>
                                    </div>
                                </div>
                            </div>--}}
                    </div>
                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faq33444" aria-expanded="true">If you cancel your monthly plan before the end of the billing cycle, you will not be charged the next month.</a>
                        </h6>
                        <div id="faq33444" class="collapse show">
                            <div class="faq-detail">
                                
                                <ul>
                                    <li>You can also change your monthly plan to a higher or lower intensity, and this will take effect at the start of the next billing cycle.</li>
                                    <li>Or, if you prefer, you can pause your account for a maximum of 4 weeks, once per billing cycle.</li>
                                    <li>Please note that while any unused credits will still be viewable on your account, you will not be able to access them after your last payment cycle ends. However, if you do decide to renew your subscription, your credits will be there for you.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div  data-aos="fade-up">
                        <h4 class="fw-bold theme-rose">Recurring number of classes:</h4>
                        <p>Total charged every 4 weeks</p>
                    </div>
                    <div class="benefit-box" data-aos="fade-up">
                        <!-- <h5 class="fw-bold">Proin ut turpis nec quam vehicula</h5> -->
                        <div class="timimg-btn mb-2 data">
                        @if($pv_master->time == 1)
                        <input type="hidden" name="id" id="p_id" value="{{$pv_master->id}}">
                            @if($time != null)
                                @foreach($time as $key => $ti)
                                    @if($key == 0)
                                    <label class="da active cl blue{{$key}}" data-key="{{$key}}" id="ad{{$ti->time}}" onclick="timeprice({{$ti->time}})">{{$ti->time}} mins</label>
                                    @else
                                    <label class="da " id="ad{{$ti->time}}" onclick="timeprice({{$ti->time}})">{{$ti->time}} mins</label>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                        <span class="">
                            <div class="dsdropdown " style="background: #fff;line-height: 15px;margin-top: 15px;position: relative;display: inline;">
                                <button class="btn langbtn" type="button"> 
                                @if(Session::get('currency') == 'EUR')
                                    <span class="lang-change"> <i class="fa-euro fa"></i> EUR </span>
                                @else
                                    <span class="lang-change"> <i class="fa fa-dollar"></i> USD </span>
                                @endif
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dsdropdown-menu" style="">
                                    <li class="dsdropdown-item selectlang text-black" style="line-height: 0;margin: 5px 0px;padding: 5px 0px;" onclick="changeLanguage('en')" data-value="USD" id="currency">
                                        <i class="fa fa-dollar"></i> USD
                                    </li>
                                    <li class="dsdropdown-item selectlang text-black" style="line-height: 0; margin: 5px 0px;padding: 5px 0px;" onclick="changeLanguage('fr')" data-value="EUR" id="currency">
                                        <i class="fa-euro fa"></i> EUR
                                    </li>
                                </ul>
                            </div>
                        </span>
                        </div>
                        <div class="plan-data">
                        @foreach($price as $price1)
                        @if(Auth::user() && Auth::user()->user_type == 2)
                        <div class="plan-box blue0 py-2 dash">
                        @else
                        <div class="plan-box blue0 py-2 dash" onclick="Cart({{$price1->id}})">
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
                        </div>
                        @php
                            $url = (Auth::check() && Auth::user()->user_type=='1')?route('student.messages'):route('teacher.messages');
                        @endphp
                        @if(Auth::check() && (Auth::user()->user_type=='1' || Auth::user()->user_type=='2') )
                            <a href="{{url('chatify/1')}}" class="btn btn-secondary w-100">Contact Us</a>
                        @else
                            <a href="{{route('front.login')}}?support=1" class="btn btn-secondary w-100">Contact Us</a>
                        @endif

            </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="section-sub-head mb-4" data-aos="fade-up">
            <span class="tagline">Trustpilot reviews</span>
            <h2>Recommended by other students</h2>
        </div>
        @php
        $review = Helper::getReview1();
        @endphp
        <div class="review-slider owl-carousel owl-theme" data-aos="fade-up">
            @if($review)
            @foreach($review as $re)
            <div class="item">
                <div class="d-flex">
                    @for ($i = 0; $i < $re->rating; $i++)
                        <i class="fa-sharp fa-solid fa-star"></i>
                        @endfor
                </div>
                <p class="m-0 headline">{{$re->title ?? ''}}</p>
                <p class="para m-0">{{$re->description ?? ''}}</p>
                @php
                $student = DB::table('users')->where('id',$re->student_id)->first();
                @endphp
                <p class="footer-review m-0"><span class="name">{{$student->name ?? ''}} </span></p>
            </div>
            @endforeach
            @else
            <h1>No Review Found</h1>
            @endif
            {{--<div class="item">
                        <div class="d-flex">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div>
                        <p class="m-0 headline">I love latogo ! </p>
                        <p class="para m-0">I love latogo !! I was learning Spanish in French in here but I hope one day
                            have Ru...</p>
                        <p class="footer-review m-0"><span class="name">Junjun Lao, </span><span>3 days ago</span></p>
                    </div>
                    <div class="item">
                        <div class="d-flex">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div>
                        <p class="m-0 headline">I love latogo ! </p>
                        <p class="para m-0">I love latogo !! I was learning Spanish in French in here but I hope one day
                            have Ru...</p>
                        <p class="footer-review m-0"><span class="name">Junjun Lao, </span><span>3 days ago</span></p>
                    </div>--}}

        </div>
    </div>
</section>
<section class="new-gradient spcial-offer" style="margin: 20px;border-radius: 80px;">
    <div class="container">
        <div class="row align-items-center">
            @php
            $class = Helper::class();
            @endphp
            @if($class)
            <div class="col-md-6">
                <img src="{{asset('uploads/trial_classes/'.$class->image)}}" class="w-100 main-img" data-aos="fade-up" alt="" />
            </div>
            <div class="col-md-6">
                <div class="title-sec" data-aos="fade-up">
                    <h2 class="text-white">{{ $class->title }}</h2>
                    <p>{!!$class->description!!}</p>
                </div>
                <!-- <div class="all-btn all-category d-flex align-items-center " data-aos="fade-up">
                    <a href="#" class="btn btn-primary btn-filled">Start now </a>
                </div> -->
            </div>

        </div>
        @else
        <h1>No Data Found</h1>
        @endif
    </div>
</section>
<section>
    <div class="help-sec" id="review">
        <div class="container">
            <div class="section-sub-head mb-4 text-center">
                <h2>Frequently asked questions</h2>
            </div>
            <div class="row">
                <div class="col-lg-6">

                </div>
            </div>
            <div class="row justify-content-center">
                @php
                $faq = Helper::getFaq();
                @endphp
                @if($faq)
                @foreach($faq as $fa)
                <div class="col-lg-6">
                    <div class="faq-card">
                        <h6 class="faq-title">
                            <a class="collapsed" data-bs-toggle="collapse" href="#faq{{$fa->id}}" aria-expanded="false">{{$fa->title}}</a>
                        </h6>
                        <div id="faq{{$fa->id}}" class="collapse">
                            <div class="faq-detail">
                                <p>{{$fa->short_description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h1>No Data Found</h1>
                @endif
                {{--<div class="faq-card">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo"
                                        aria-expanded="false">How much time I will need to learn this app?</a>
                                </h6>
                                <div id="faqtwo" class="collapse">
                                    <div class="faq-detail">
                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                        <p>If several languages coalesce, the grammar of the resulting language is more
                                            simple and regular than that of the individual languages. The new common
                                            language will be more simple and regular than the existing European
                                            languages.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-card">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqthree"
                                        aria-expanded="false">Is there a month-to-month payment option?</a>
                                </h6>
                                <div id="faqthree" class="collapse">
                                    <div class="faq-detail">
                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                        <p>If several languages coalesce, the grammar of the resulting language is more
                                            simple and regular than that of the individual languages. The new common
                                            language will be more simple and regular than the existing European
                                            languages.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <div class="faq-card">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqfour"
                                        aria-expanded="false">What’s the benefits of the Premium Membership?</a>
                                </h6>
                                <div id="faqfour" class="collapse">
                                    <div class="faq-detail">
                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                        <p>If several languages coalesce, the grammar of the resulting language is more
                                            simple and regular than that of the individual languages. The new common
                                            language will be more simple and regular than the existing European
                                            languages.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-card">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqfive"
                                        aria-expanded="false">Are there any free tutorials available?</a>
                                </h6>
                                <div id="faqfive" class="collapse">
                                    <div class="faq-detail">
                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                        <p>If several languages coalesce, the grammar of the resulting language is more
                                            simple and regular than that of the individual languages. The new common
                                            language will be more simple and regular than the existing European
                                            languages.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-card">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqsix"
                                        aria-expanded="false">How can I cancel my subscription plan?</a>
                                </h6>
                                <div id="faqsix" class="collapse">
                                    <div class="faq-detail">
                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                        <p>If several languages coalesce, the grammar of the resulting language is more
                                            simple and regular than that of the individual languages. The new common
                                            language will be more simple and regular than the existing European
                                            languages.</p>
                                    </div>
                                </div>
                            </div>--}}

            </div>
        </div>
    </div>
    </div>
    @if(Auth::check())
        @php 
            $user = Auth::user()->id;
            $ref = DB::table('referal_data_amount_new')->where('ref_rec_id',$user)->first();
        @endphp
        @if(isset($ref) && $ref->status == 0)
            <input type="hidden" id="ref_no" value="0">
        @else
            <input type="hidden" id="ref_no" value="1">
        @endif
    @endif
</section>
@if(isset($pr_id))
<input type="hidden" id="pr_id" value="{{$pr_id}}">
@endif

<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModalll">
    Launch demo modal
  </button>
  <!-- Button trigger modal -->
<style>
    #burst-12 {
        background: #7a7fe9;
        width: 80px;
        height: 80px;
        position: relative;
        text-align: center;
        margin: 30px auto;
      }
      #burst-12:before,
      #burst-12:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 80px;
        width: 80px;
        background: #7a7fe9;
      }
      #burst-12:before {
        transform: rotate(30deg);
      }
      #burst-12:after {
        transform: rotate(60deg);
      }
      .center-wpos{
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 30px;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
      }
      #exampleModalll{
        color:#fff;
      }
      .with_pop{
        max-width: 290px;
      }
</style>
  <!-- Modal -->
  <div class="modal fade" id="exampleModalll" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog with_pop">
      <div class="modal-content" style="    background-color: #f6697b;">
        <div class="modal-body text-center p-4">
          <h3 class="fs-1 fw-bold text-white">45 min</h3>
          <h4 class="pb-4 text-uppercase text-white">Trial Class</h4>
          <div class="position-relative">
            <div id="burst-12">
            </div>
            <div class="center-wpos">
                $5
            </div>
          </div>
          <a href="/student/checkoutNew" class="btn btn-warning fw-bold mt-3">Book Now</a>
        </div>
        <div class="modal-footer d-none">
          <button type="button" class="btn btn-secondary" >Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('.pre-loader').hide();
        var price_value = $('#pr_id').val();
        if(price_value != ''){
            var buttonElement = document.getElementById('ac'+price_value);
            buttonElement.click();
        }
    });
    // $(document).ready(function() {
    //     var active = 1;
    //         $.ajax({
    //             url: "{{ route('price') }}",
    //             type: "get",
    //             data: {
    //                 'active': 1,
    //             },
    //             success: function(response) {
    //                 console.log(response);
    //                 $('.dash').replaceWith(response);
    //             }
    //         });
    // });
    $('.review-slider').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
    $(document).ready(function() {
        $('.timimg-btn label').click(function() {
            $('.timimg-btn label').removeClass('active');
            $(this).addClass('active');
        })
    });

    function changePrice(x, y) {
        $('.plan-box').removeClass('active');
        $('.timimg-btn').hide();
        $('.benefit-box .plan-box').removeClass('blue');
        $('.benefit-box .plan-box').removeClass('lblue');
        if (x == "private") {
            // alert(x);
            $(y).addClass("active");
            $('.timimg-btn').show();
            $('.benefit-box .plan-box').addClass('blue');
        } else if (x == "partner") {
            $(y).addClass("active");

        } else if (x == "team") {
            $(y).addClass("active");
            $('.benefit-box .plan-box').addClass('lblue');
        }

    }

    function pricing(value) {
        var active = value;
        $('.cl').removeClass("active");
        $('#ac' + active).addClass("active");
        var type = $('.cl.active').attr('data-key');
        $('.benefit-box .dash').removeClass("blue0 blue1 blue2");
        $.ajax({
            url: "{{ route('price') }}",
            type: "get",
            data: {
                'active': active,
            },
            success: function(response) {
                console.log(response);
                $('.plan-data').html('');
                $('.plan-data').html(response);
                $('.benefit-box .plan-box').addClass("blue" + type);
            }
        });
        $.ajax({
            url: "{{ route('time') }}",
            type: "get",
            data: {
                'active': active,
            },
            success: function(response) {
                console.log(response);
                $('.data').html(response);
            }
        });

    }

    function timeprice(value) {
        var active = value;
        var id = $('#p_id').val();
        $('.da').removeClass("active");
        $('#ad' + active).addClass("active");
        var type = $('.cl.active').attr('data-key');
        $('.benefit-box .dash').removeClass("blue0 blue1 blue2");
        $.ajax({
            url: "{{ route('timeprice') }}",
            type: "get",
            data: {
                'active': active,
                'id': id,
            },
            success: function(response) {
                console.log(response);
                $('.plan-data').html(response);
                $('.benefit-box .plan-box').addClass("blue" + type);
            }
        });
    }

    function Cart(value) {
        var id = value;
        $('.pre-loader').show();
        $.ajax({
            url: "{{ route('student.cart.store') }}",
            type: "get",
            data: {
                'id': id,
            },
            success: function(response) {
                if (response.success == true) {
                    window.setTimeout(function() {
                        window.location = "{{ url('/')}}" + "/student/cart-list";
                    }, 2000);

                }
                if (response.success == false) {
                    window.setTimeout(function() {
                        window.location = "{{ url('/')}}" + "/user/login";
                    }, 2000);

                }
            }
        });
    }
    $(document).ready( function(){
           var v12 = $('#ref_no').val();
           if(v12 == 0){
                $('#exampleModalll').modal('show');
           }
        });
</script>
@endpush

@extends('layouts.dashboard.master')
@section('content')
<style>
        :root {
        --star-size: 60px;
        --star-color: #777;
        --star-background: #fc0;
        }
        .average-rating span {
            color: #ffb54a;
            font-size: 20px;
        }

        .Stars {
        --percent: calc(var(--rating) / 5 * 100%);

        display: inline-block;
        font-size: 34px;
        font-family: Times; // make sure ★ appears correctly
        line-height: 1;

        &::before {
            content: '★★★★★';
            letter-spacing: -5px;
            background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        }
</style>
<section class="home-slide d-flex align-items-center " id="counter">
    <div class="container">
        <div class="row ">
            @php
            $banner = Helper::getBanner();
            @endphp
            @if($banner)
            <div class="col-md-7">
                <div class="home-slide-face aos" data-aos="fade-up">
                    <div class="home-slide-text ">
                        <!-- <h5>The Leader in Online Learning</h5> -->
                        <h5>{{$banner->title}}</h5>
                        <h1>{{$banner->short_description}}</h1>
                        <!-- <h1>Giving you a German voice with our live online classes</h1> -->
                        @php
                        $banner1 = Helper::getBannerPoint();
                        @endphp
                        @if($banner1)
                        <ul style="list-style:none;" class="p-0">
                            @foreach($banner1 as $bann)
                            <li class="homelistds"><img src="assets/img/checkicon.png" style="width: 20px;margin-right: 5px;" alt="" />{{$bann->point}}</li>

                            @endforeach
                        </ul>
                        @endif
                    </div>
                    <div class="trust-user">
                        <div class="trust-rating d-flex align-items-baseline">
                            <div class="rate-head">
                                <h2><b class="counter-value"  data-count="{{$banner->count_complete_lession}}">0</b>+</h2>
                                <small style="white-space: nowrap;">Completed Lessons</small>
                            </div>
                            <div class="rating d-flex align-items-center">
                                <h2 class="d-inline-block average-rating">{{$banner->review}}</h2>
                                @for ($i = 0; $i < $banner->review; $i++)
                                    <i class="fas fa-star filled"></i>
                                    @endfor
                            </div>
                        </div>
                    </div>
                    <div class="all-btn all-category d-flex align-items-center mt-3">
                        @if(Auth::user())@else
                        <a href="{{url('/student/register')}}" class="btn btn-primary">Get started</a>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <h1>No Banner Data</h1>
            @endif
            <div class="col-md-5 d-flex align-items-center">
                <div class="girl-slide-img aos" data-aos="fade-up">
                    <img src="{{asset('uploads/banner/'.$banner->banner_image)}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section student-course">
    <div class="container">
        <div class="course-widget">
            <div class="row">
                @php
                $bottom_banner = Helper::bottom_banner();
                @endphp
                @if($bottom_banner)
                @foreach($bottom_banner as $bann)
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ asset('upload/bottom_banner').'/'.$bann->image }}" alt="">
                                </div>
                                <div class="course-inner-content">
                                    <h4><b class="counter-value" data-count="{{ $bann->title }}"></b>{{ $bann->title_k }}</h4>
                                    <p>{{ $bann->sub_title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h1>No Data Found</h1>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="why-latogo-sec pb-0">
    <div class="container">
        <div class="section-sub-head">
            <!--<span>Flexible for Busy</span>-->
            <h2 class="mb-2">Why is Latogo the best choice for you?</h2>
            <p class="mb-1">We combine the advantages of Private Tutoring, Language Institute and Language Learning App. </p>
        </div>
        @php
        $resion = Helper::getResionOfBest();
        @endphp
        <div class="why-latogo-main owl-carousel owl-theme py-5">
            @if($resion)
            @foreach($resion as $re)
            <div class="item">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="section-sub-head">
                            <h2 class="fs-28">{{$re->title}}</h2>
                            <p class="mt-2">{{$re->short_title}}</p>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <img src="{{asset('uploads/resion/'.$re->icon)}}" class="w-100" alt="" />
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h1>No Data Found</h1>
            @endif
        </div>
    </div>
</section>
<section class="section how-it-works">
    <div class="container">
        @php
        $cat_class = Helper::getCategoryClass();
        @endphp
        @if($cat_class)
        <div class="owl-carousel mentoring-course owl-theme aos" data-aos="fade-up">
            @foreach($cat_class as $key=>$cat)
            <div class="feature-box text-center ">
                <a href="{{url('/view1/'.base64_encode($key+1))}}">
                <div class="feature-bg">
                    <div class="feature-header">
                        <div class="feature-icon">
                            <img src="{{asset('uploads/categroy_class/'.$cat->icon)}}" alt="">
                        </div>
                        <div class="feature-cont">
                            <div class="feature-text">{{$cat->class_category}}</div>
                        </div>
                    </div>
                    <p>{{$cat->instructor}}</p>
                </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<section class="section new-course">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head">
                <span>What’s New</span>
                <h2>Featured Courses</h2>
            </div>
            <div class="all-btn all-category d-flex align-items-baseline">
                <a href="{{url('/course-structure')}}" class="btn btn-primary">All Courses</a>
            </div>
        </div>
        <div class="section-text aos" data-aos="fade-up">
            <p class="mb-0">Discover German cultures and build careers faster than you expect. Go through German
                language course catalogues and narrow down the course modules that interest you. Join
                us to learn German online with native teachers by upgrading 100% practical skills and
                gathering comprehensive experience with the real world.</p>
        </div>
        <div class="course-feature">
            <div class="owl-carousel owl-theme course-feature-silder">
                @php
                $homebookclasses = Helper::homebookclasses();
                @endphp
                @if($homebookclasses)
                @foreach($homebookclasses as $isfe)
                <div class="">
                    <div class="course-box d-flex aos" data-aos="fade-up">
                        <div class="product">
                            <div class="product-img">

                            @if(isset($isfe))
                                @if($isfe->youtube_url)
                                <a><iframe width="100%" height="200" src="{{ $isfe->youtube_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe></a>
                                @else
                                <a><iframe width="420" height="345" src="https://www.youtube.com/"></iframe></a>
                                @endif
                            @endif

                            </div>
                            <div class="product-content">
                                <div class="course-group d-flex">
                                    <div class="course-group-img d-flex">

                                        @php
                                        $findTeacherdetails = Helper::findTeacherdetails($isfe->teacher_id??'');
                                        @endphp
                                        @if(isset($findTeacherdetails))
                                            @if($findTeacherdetails->avatar)
                                            <a href="{{ url('student/class_details',['id'=>$isfe->id]) }}"><img src="{{ url('uploads/user/avatar/'.$findTeacherdetails->avatar) }}" alt="" class="img-fluid"></a>
                                            @else
                                            <a href="{{ url('student/class_details',['id'=>$isfe->id]) }}"><img src="{{ asset('/assets/img/user/user.png') }}" alt="" class="img-fluid"></a>
                                            @endif
                                        @endif
                                        <!-- <a href="{{ url('student/class_details',['id'=>$isfe->id]) }}"><img src="{{ url('uploads/user/avatar/'.$findTeacherdetails->avatar ?? '') }}" alt="" class="img-fluid"></a> -->
                                        <div class="course-name">
                                            @php
                                            $findTeacherName = Helper::findTeacherName($isfe->teacher_id??'');
                                            @endphp
                                            <h4><a href="{{ url('student/class_details',['id'=>$isfe->id]) }}">{{ $findTeacherName->name ?? '' }}</a></h4>
                                            <p>Professional Teacher</p>
                                        </div>
                                    </div>
                                    <div class="course-share d-flex align-items-center justify-content-center">
                                        @php
                                        $wishlist = App\Models\wishlist::where('class_id',$isfe->id)->where('user_id',Auth::user()->id ?? '')->get();
                                        $wish_count = count($wishlist);
                                        @endphp
                                        @if(Auth::user() && Auth::user()->user_type == 2)@else
                                        @if($wish_count)
                                        <a href="{{url('/wishlist/remove',['id'=>$isfe->id])}}"><i class="fa fa-heart"></i></a>
                                        @else
                                        <a href="{{url('/wishlist',['id'=>$isfe->id])}}"><img src="{{asset('assets/img/icon/wish.svg')}}" alt="img"></a>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                <h3 class="title instructor-text">
                                    <a href="{{ url('student/class_details',['id'=>$isfe->id]) }}">{!! substr($isfe->description,0,50) !!}...</a>
                                </h3>
                                <div class="course-info d-flex align-items-center">
                                    <div class="rating-img d-flex align-items-center">
                                        <img src="assets/img/speaking-head.png" style="width:24px;" alt="">&nbsp&nbsp
                                        @php
                                        $findTeacherdetails = Helper::findTeacherdetails($isfe->teacher_id ?? '');
                                        if($findTeacherdetails!=null && $findTeacherdetails->language!=null)
                                        $lang_data = json_decode($findTeacherdetails->language);
                                        else {
                                        $lang_data = array();
                                        }
                                        @endphp

                                        <?php
                                        for ($i = 0; $i < count($lang_data); $i++) {
                                            $lang_name = DB::table("language_masters")->where('id', $lang_data[$i])->first();
                                            $lang_name = $lang_name->language;
                                            if (!$i == 0) {
                                                echo ", ";
                                            }
                                            echo  $lang_name;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="rating">
                                    @if($isfe->rating/2 != 0)
                                        <div class="Stars" style="--rating: {{$isfe->rating/2}};" aria-label="Rating of this product is 2.3 out of 5."></div>
                                        <span class="d-inline-block average-rating"><span>{{$isfe->rating/2 ?? ''}}</span></span>
                                    @endif
                                </div>
                                <div class="all-btn all-category d-flex align-items-center">
                                    @if(Auth::check() && Auth::user()->user_type == 1)
                                    <a href="{{ url('student/class_details',['id'=>$isfe->id]) }}" class="btn btn-primary">Book a class</a>
                                    @else
                                    <a href="{{ url('/view') }}" class="btn btn-primary">Book a class</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h1>No Data Found</h1>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="section master-skill">
    <div class="container">
        <div class="row">
            @php
            $whatnew = Helper::getwhatnew();
            @endphp
            @if($whatnew)
            <div class="col-lg-7 col-md-12">
                <div class="section-header aos" data-aos="fade-up">
                    <div class="section-sub-head">
                        <span>What’s New</span>

                        <h2>{{$whatnew->title}}</h2>
                    </div>
                </div>
                <div class="section-text aos" data-aos="fade-up">
                    <p>{{ $whatnew->description }}</p>
                </div>
                <div class="career-group aos" data-aos="fade-up">
                    <div class="row">
                        @php
                        $whatnewpoint = Helper::whatnewpoint();
                        @endphp
                        @if($whatnewpoint)

                        @foreach($whatnewpoint as $new)
                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="certified-group blur-border d-flex">
                                <div class="get-certified d-flex align-items-center">
                                    <div class="blur-box">
                                        <div class="certified-img ">
                                            <img src="{{asset('uploads/whats-new-point/'.$new->image)}}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                    <p>{{ $new->title }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{--@else
                        <h1>No Data Found</h1>--}}
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 d-flex align-items-end">
                <div class="career-img aos" data-aos="fade-up">
                    <img src="{{asset('uploads/what-new/'.$whatnew->image)}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        {{--@else
        <h1>No Data Found</h1>--}}
        @endif
    </div>
</section>
<section class="section trend-course d-none">
    <div class="container">
        <div class="feature-instructors">
            <div class="section-header aos" data-aos="fade-up">
                <div class="section-sub-head feature-head text-center">
                    <h2>Meet Our Head Instructors</h2>
                    <div class="section-text aos" data-aos="fade-up">
                        <p class="mb-0">Our head instructors make the online German language courses
                            interactive, interesting, focused, and life-relevant.
                        </p>
                    </div>
                </div>
            </div>
            <div class="owl-carousel instructors-course owl-theme aos" data-aos="fade-up">
                <div class="instructors-widget">
                    <div class="instructors-img ">
                        <a href="javascript:void(0)">
                            <img class="img-fluid" alt="" src="assets/img/thomos.jpg">
                        </a>
                    </div>
                    <div class="instructors-content text-center">
                        <h5><a href="javascript:void(0)">Thomos</a></h5>
                        <p>German Language</p>
                        <div class="student-count d-flex justify-content-center">
                            <i class="fa-solid fa-user-group"></i>
                            <span>50 Students</span>
                        </div>
                    </div>
                </div>
                <div class="instructors-widget">
                    <div class="instructors-img">
                        <a href="javascript:void(0)">
                            <img class="img-fluid" alt="" src="assets/img/claudia.jpg">
                        </a>
                    </div>
                    <div class="instructors-content text-center">
                        <h5><a href="javascript:void(0)">Claudia</a></h5>
                        <p>German Language</p>
                        <div class="student-count d-flex justify-content-center">
                            <i class="fa-solid fa-user-group yellow"></i>
                            <span>50 Students</span>
                        </div>
                    </div>
                </div>
                <div class="instructors-widget">
                    <div class="instructors-img">
                        <a href="javascript:void(0)">
                            <img class="img-fluid" alt="" src="assets/img/olivia.jpg">
                        </a>
                    </div>
                    <div class="instructors-content text-center">
                        <h5><a href="javascript:void(0)">Olivia</a></h5>
                        <p>German Language</p>
                        <div class="student-count d-flex justify-content-center">
                            <i class="fa-solid fa-user-group violet"></i>
                            <span>50 Students</span>
                        </div>
                    </div>
                </div>
                <div class="instructors-widget">
                    <div class="instructors-img">
                        <a href="javascript:void(0)">
                            <img class="img-fluid" alt="" src="assets/img/katha.jpg">
                        </a>
                    </div>
                    <div class="instructors-content text-center">
                        <h5><a href="javascript:void(0)">Katha</a></h5>
                        <p>German Language</p>
                        <div class="student-count d-flex justify-content-center">
                            <i class="fa-solid fa-user-group orange"></i>
                            <span>50 Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="section d-none share-knowledge why-latogo">
    <div class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="content-ds">
                        <h3 class="fw-bold">Flexible for busy people</h3>
                        <p>We offer 550k classes per year. That means over 60 classes start every hour around the clock.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="w-100" src="assets/img/desktop.svg" alt="" />
                </div>

                <div class="col-md-6">
                    <img class="w-100" src="assets/img/desktop2.svg" alt="" />
                </div>
                <div class="col-md-6">
                    <div class="content-ds">
                        <h3 class="fw-bold">Professional teachers</h3>
                        <p>Our native-level teachers are located worldwide so you get to know cultural differences in a language.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="content-ds">
                        <h3 class="fw-bold">Start speaking confidently</h3>
                        <p>Teachers will mainly speak the learning-language in class, so you get comfy with the language fast.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="w-100" src="assets/img/desktop3.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section lead-companies pt-5">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center">
                <span>Trusted By</span>
                <h2>Our Students From All Around The World</h2>
            </div>
        </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
        <div class="lead-group aos" data-aos="fade-up">
            <div class="lead-group-slider owl-carousel owl-theme">
                @php
                $clients = Helper::clients();
                @endphp
                @if($clients)

                @foreach($clients as $client)

                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="" src="{{asset('uploads/client/'.$client->image)}}">
                    </div>
                </div>
                @endforeach
                @else
                <h1>No Data Found</h1>
                @endif
            </div>
        </div>
        </div>
        </div>


    </div>
</section>
<section class="section lead-companies pt-5">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center">
                <span>Our Students</span>
                <h2>Hear our students' favourite language wins</h2>
            </div>
        </div>
        @php
        $video = Helper::getvideo();
        @endphp
        <div class="video-sec-testi">
            <div class="video-test-sec owl-carousel owl-theme">
                @if($video)
                @foreach($video as $videos)
                <div class="item">
                    <div class="content-ds">
                        <video width="100%" height="auto" class="video-ds d-block" controlsList="nodownload">
                            <source src="{{asset('uploads/video/'.$videos->video)}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <div class="text-sec">
                            <i class="fa-regular for-pause fa-circle-play"></i>
                            <p class="">{{$videos->name}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<section class="section share-knowledge">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="knowledge-img aos" data-aos="fade-up">
                    <img src="assets/img/share.png" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="join-mentor aos" data-aos="fade-up">
                    <h2 class="mb-4">Frequently asked questions</h2>
                    @php
                    $faq = Helper::getlatestFaq();
                    @endphp
                    <div class="col-lg-12">
                        @if($faq)
                        @foreach($faq as $key => $fa)
                        <div class="faq-card">
                            <h6 class="faq-title">
                                <a class="collapsed" data-bs-toggle="collapse" href="#faq{{$fa->id}}" aria-expanded="false" data-id="0">{{$fa->title}}</a>
                            </h6>
                            <div id="faq{{$fa->id}}" class="collapse" style="">
                                <div class="faq-detail">
                                    <p>{{$fa->short_description}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                    </div>
                    <h1>No faq found</h1>
                    @endif
                </div>
                <div class="all-btn all-category d-flex align-items-center">
                    <a href="{{url('/support')}}" class="btn btn-primary">Read all FAQ</a>
                </div>
            </div>
        </div>
</section>
<section class="testimonial-four user-love">
@php
    $testimonial = Helper::testimonial();
    @endphp
@if($testimonial)
@if(isset($testimonial) && count($testimonial) != 0)
    <div class="section-header white-header aos aos-init aos-animate" data-aos="fade-up">
        <div class="section-sub-head feature-head text-center">
            <span>Check out these real reviews</span>
            <h2>What do our students say about Latogo?</h2>
        </div>
    </div>
    <div class="review">
        <div class="container">
            <div class="testi-quotes">
                <img src="assets/img/qute.png" alt="">
            </div>
            <div class="mentor-testimonial lazy slider aos" data-aos="fade-up" data-sizes="50vw ">
                
                @foreach($testimonial as $test)

                <div class="d-flex justify-content-center">
                    <div class="testimonial-all d-flex justify-content-center">
                        <div class="testimonial-two-head text-center align-items-center d-flex">
                            <div class="testimonial-four-saying ">
                                <div class="testi-right">
                                    <img src="assets/img/qute-01.png" alt="">
                                </div>
                                <p>{{ $test->description }}</p>
                                <div class="four-testimonial-founder">
                                    <div class="fount-about-img">
                                        <a href="javascript:void(0)"><img src="{{asset('uploads/testimonials/'.$test->image)}}" alt="" class="img-fluid"></a>
                                    </div>
                                    <h3><a href="javascript:void(0)">{{ $test->title }}</a></h3>
                                    <span>{{ $test->designation}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
                @endif
            </div>
        </div>
    </div>
@endif
</section>
@if(Auth::user() !== Null)@else
<section class="section become-instructors aos" data-aos="fade-up">
    <div class="container">
        <div class="row">
            @php
            $short_banners = Helper::short_banners();
            @endphp
            @if($short_banners)
            <div class="col-lg-6 col-md-6 d-flex">
                <a href="{{ url('become-a-teacher-page') }}">
                    <div class="student-mentor cube-instuctor ">
                        <h4>{{ $short_banners->title }}</h4>
                        <div class="row">
                            <div class="col-lg-7 col-md-12">
                                <div class="top-instructors">
                                    <p>{!! $short_banners->description !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <div class="mentor-img">
                                    <img class="img-fluid position-relative" alt="" src="{{asset('uploads/short_banners/'.$short_banners->image)}}" style="float: right; max-width: none;    max-width: 260px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{--@else
            <h1>No Data Found</h1>--}}
            @endif
            @php
            $transform_short_banners = Helper::transform_short_banners();
            @endphp
            @if($transform_short_banners)

            <div class="col-lg-6 col-md-6 d-flex">
                <a href="{{url('/teacher/register')}}">
                    <div class="student-mentor yellow-mentor">
                        <h4>{{ $transform_short_banners->title }}</h4>
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="top-instructors">
                                    <p>{!! $transform_short_banners->description !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="mentor-img">
                                    <img class="img-fluid position-relative" alt="" src="{{asset('uploads/transform_short_banners/'.$transform_short_banners->image)}}" style="float: right; max-width: none;    max-width: 260px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{--@else
            <h1>No Data Found</h1>--}}
            @endif
        </div>
    </div>
</section>
@endif
<section class="section latest-blog">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center mb-0">
                <h2>Latest Blogs</h2>
            </div>
        </div>
        @php
        $blog = Helper::getBlog();
        @endphp
        <div class="owl-carousel blogs-slide owl-theme aos" data-aos="fade-up">
            @if($blog)
            @foreach($blog as $blogs)
            <div class="instructors-widget blog-widget">
                <div class="instructors-img">
                    <a href="{{url('/blog-fetch',encrypt(['id'=> $blogs->id]))}}">
                        <img class="img-fluid" alt="" src="{{asset('uploads/blogs/'.$blogs->image)}}">
                    </a>
                </div>
                <div class="instructors-content text-center">
                    <h5><a href="{{url('/blog-fetch',encrypt(['id'=> $blogs->id]))}}">{{$blogs->title}}</a></h5>
                    <div class="student-count d-flex justify-content-center">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>{{date('M d, Y', strtotime($blogs->created_at))}}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h1>No Blog Founds</h1>
            @endif

            {{--<div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-02.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">11 Tips to Help You Get New Clients</a></h5>
                            <p>Sales Order</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>May 20, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-03.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">An Overworked Newspaper Editor</a></h5>
                            <p>Design</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>May 25, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-04.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">A Solution Built for Teachers</a></h5>
                            <p>Seo</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>Jul 15, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-02.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">Attract More Attention Sales And Profits</a></h5>
                            <p>Marketing</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>Sep 25, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-03.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">An Overworked Newspaper Editor</a></h5>
                            <p>Marketing</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>May 25, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-04.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">A Solution Built for Teachers</a></h5>
                            <p>Analysis</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>May 15, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-02.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">11 Tips to Help You Get New Clients</a></h5>
                            <p>Development</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>Jun 20, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-03.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">An Overworked Newspaper Editor</a></h5>
                            <p>Sales</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>May 25, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="instructors-widget blog-widget">
                        <div class="instructors-img">
                            <a href="#">
                                <img class="img-fluid" alt="" src="assets/img/blog/blog-04.jpg">
                            </a>
                        </div>
                        <div class="instructors-content text-center">
                            <h5><a href="#">A Solution Built for Teachers</a></h5>
                            <p>Marketing</p>
                            <div class="student-count d-flex justify-content-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>April 15, 2022</span>
                            </div>
                        </div>
                    </div>--}}
        </div>
        <div class="enroll-group aos" data-aos="fade-up">
            <div class="row ">
                @php
                $education_info = Helper::education_info();
                @endphp
                @if($education_info)
                @foreach($education_info as $info)

                <div class="col-lg-4 col-md-6">
                    <div class="total-course d-flex align-items-center">
                        <div class="blur-border">
                            <div class="enroll-img ">
                                <img src="{{asset('uploads/education_info/'.$info->image)}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="course-count">
                            @if(($info->count) > 999)
                            <h3><span class="counterUp">{{ $info->count/1000 }}</span>K+</h3>
                            @else
                            <h3><span class="counterUp">{{ $info->count }}</span></h3>
                            @endif
                            <p>{{ $info->title }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h1>No Data Found</h1>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    $(document).ready(function() {

        $(document).on('click', '.fa-circle-pause', function() {
            // alert('pause');
            $(this).parent().parent().find('.video-ds').trigger('pause');
            $(this).removeClass('fa-circle-pause');
            $(this).addClass('fa-circle-play');
        });
        $(document).on('click', ".fa-circle-play", function() {
            // alert('play');
            $(this).parent().parent().find('.video-ds').trigger('play');
            $(this).removeClass('fa-circle-play');
            $(this).addClass('fa-circle-pause');
        });
        $(document).on('click', '.faq-card', function(e) {
            e.preventDefault();
            // console.log($(this).parent().find('.collapse').length);
            // $('.faq-card .collapse').removeClass('show');
            // $('.faq-card .collapse').removeClass('show');
            // $('.faq-card .faq-title a').removeClass('collapsed');
            // if($(this).find('a').hasClass('collapsed')){
            //     $(this).find('a').toggleClass('collapsed');
            // }else{
            //     $(this).find('a').toggleClass('collapsed')
            // }

            // alert($(this).find('a').toggleClass('collapsed'));
            // $(this).find('a').hide();
            // $('.faq-card').each(function(){
            //     var atag = $(this).find('a');
            //     // alert(atag.attr('class'));
            //     if(atag.attr('class')=="collapsed")
            //     {
            //       alert('yes');
            //     //   $(this).find('a').addClass('collapsed')

            //     }
            //     else
            //     {
            //         alert('no');
            //         // $(this).find('a').removeClass('collapsed')
            //     }
            // });


            var th = $(this).find('a');
            $('.faq-card').each(function(){
                // alert($(this).find('a').attr('data-id')==1);
                // alert($(this).find('a').attr('href') != th.attr('href'));
                if($(this).find('a').attr('href') != th.attr('href') && $(this).find('a').attr('data-id')==1)
                {
                    $(this).find('a').addClass("collapsed");
                    $(this).find('.collapse').removeClass("show");
                    $(this).find('a').attr('data-id',0);
                }

            });

            if(th.data('id')==1)
            {
                th.attr('data-id',0);
            }
            else{
                th.attr('data-id',1);
            }

        });
    });
    $('.why-latogo-main').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    $('.course-feature-silder').owlCarousel({
        loop:false,
        margin: 10,
        nav: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })
    $('.video-test-sec').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
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
    var a = 0;
    $(window).scroll(function () {
    var oTop = $("#counter").offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop) {
        $(".counter-value").each(function () {
        var $this = $(this),
            countTo = $this.attr("data-count");
        $({
            countNum: $this.text(),
        }).animate({
            countNum: countTo,
            },

            {
            duration: 2000,
            easing: "swing",
            step: function () {
                $this.text(Math.floor(this.countNum));
            },
            complete: function () {
                $this.text(this.countNum);
                //alert('finished');
            },
            }
        );
        });
        a = 1;
    }
    });
</script>
@endpush

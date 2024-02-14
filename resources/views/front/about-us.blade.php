@extends('layouts.dashboard.master1')
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
  font-family: Times; 
  line-height: 1;
  
  &::before {
    content: '★★★★★';
    letter-spacing: -2px;
    background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
}
</style>
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="breadcrumb-list">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item">About us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
        <section class="home-two-slide d-flex align-items-center" style="background-image: url(assets/img/banner.png);">
            <div class="container">
                <div class="row ">
                @php
                    $about = Helper::getAboutus();
                @endphp
                    <div class="col-lg-8 col-12" data-aos="fade-up">
                        <div class="home-slide-face">
                            <div class="home-slide-text ">
                                <h5>Our Story</h5>
                                <h1>{{$about->title ?? ''}}</h1>
                            </div>
                            <div class="trust-user-two">
                                <p>{{$about->short_description ?? ''}} </p>
                                <div class="rating-two"> 
                                @if($about->rating != 0)
                                    <span>{{$about->rating}}</span>
                                    <div class="Stars" style="--rating:{{$about->rating}};" aria-label="Rating of this product is 2.3 out of 5."></div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shapes">
                    <img class="shapes-one" src="{{asset('assets/img/bg/home-right.png')}}" alt="">
                    <img class="shapes-two" src="{{asset('assets/img/bg/home-right-bottom.png')}}" alt="">
                    <img class="shapes-middle" src="assets/img/bg/home-middle.png" alt="">
                    <img class="shapes-four wow animate__animated animate__slideInLeft"
                        src="assets/img/bg/home-left.png" alt="">
                </div>

            </div>
        </section>
        <section class="master-skill-three">
            <div class="master-three-vector">
                <img class="ellipse-right img-fluid" src="assets/img/bg/pattern-01.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12" data-aos="fade-up">
                        <div class="master-three-images">
                            <div class="master-three-left">
                                @if($about->image ?? '')
                                <img class="img-fluid" src="{{asset('uploads/about-us/'.$about->image)}}" alt="image-banner"
                                    title="image-banner">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 " data-aos="fade-up">
                        <div class="home-three-head" data-aos="fade-up">
                            <span class="home-slide-text">
                                <h5>Our Story</h5>
                            </span>
                            <h2>{{$about->short_title ?? ''}}</h2>
                        </div>
                        <div class="home-three-content" data-aos="fade-up">
                            <p>{!!$about->long_description ?? ''!!}</p>
                        </div>
                        {{--<div class="skils-group">
                            <div class="row">
                                <div class="col-lg-6 col-xs-12 col-sm-6 col-6" data-aos="fade-up">
                                    <div class="skils-icon-item">
                                        <div class="skils-icon">
                                            <img class="img-fluid" src="assets/img/icon-three/career-01.svg"
                                                alt="certified">
                                        </div>
                                        <div class="skils-content">
                                            <p class="mb-0">10+ Interactive tools</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12 col-sm-6 col-6" data-aos="fade-up">
                                    <div class="skils-icon-item">
                                        <div class="skils-icon">
                                            <img class="img-fluid" src="assets/img/icon-three/career-02.svg"
                                                alt="Build skills">
                                        </div>
                                        <div class="skils-content">
                                    
                                         <p class="mb-0">21+ Countries</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12 col-sm-6 col-6" data-aos="fade-up">
                                    <div class="skils-icon-item">
                                        <div class="skils-icon">
                                            <img class="img-fluid" src="assets/img/icon-three/career-03.svg"
                                                alt="Stay Motivated">
                                        </div>
                                        <div class="skils-content">
                                            <p class="mb-0">5K Renewed Packages</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12 col-sm-6" data-aos="fade-up">
                                    <div class="skils-icon-item">
                                        <div class="skils-icon">
                                            <img class="img-fluid" src="assets/img/icon-three/career-04.svg"
                                                alt="latest cloud">
                                        </div>
                                        <div class="skils-content">
                                            <p class="mb-0">99% Happy Students</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </section>

        <section class="section new-course">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 order-lg-2 order-xs-1 order-sm-1">
                        <div class="home-three-head">
                            <h2 class="text-center">Why We?</h2>
                        </div>
                        <div class="stylist-gallery">
                        @php
                            $why = Helper::getWhywe();
                        @endphp
                            <div class="row">
                                @if($why)
                                @foreach($why as $wh)
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div
                                        class="about-image count-one d-flex align-items-center justify-content-center flex-fill project-details">
                                        <div class="about-count">
                                            <div class="course-img">
                                                <img src="{{asset('uploads/why-we/'.$wh->icon)}}" alt="">
                                            </div>
                                            <div class="count-content-three course-count ms-0">
                                                <h4><span class="">{{$wh->title}}</span></h4>
                                                <p class="mb-0">{{$wh->short_title}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <h1>No any Data</h1>
                                @endif
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="feature-instructors-sec">
            <div class="container">
                <div class="header-two-title text-center" data-aos="fade-up">
                    <p class="tagline">New Courses</p>
                    <h2>Meet Our Head Instructors</h2>
                    <div class="header-two-text aos" data-aos="fade-up">
                        <p class="mb-0">Our head instructors make the online German language courses interactive, interesting, focused, and life-relevant.</p>
                    </div>
                </div>

                <div class="featured-instructor-two">
                @php
                    $head = Helper::getHead();
                @endphp
                    <div class="row">
                        @if($head)
                        @foreach($head as $he)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12" data-aos="fade-up">
                            <div class="instructors-widget">
                                <div class="instructors-img">
                                    <a href="#">
                                        <img class="img-fluid" alt="" src="{{asset('uploads/head/'.$he->image)}}">
                                    </a>
                                    
                                </div>
                                <div class="course-details-two">
                                    <div class="instructors-content text-center">
                                        <h5><a href="#">{{$he->name}}</a></h5>
                                        <p>{{$he->short_description}}</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h1>No data found</h1>
                        @endif
                      
                    </div>
                </div>
                </div>

@endsection

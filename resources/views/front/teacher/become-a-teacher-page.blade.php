@extends('layouts.dashboard.master2')
@section('content')
<style>
.text-danger{
    font-size: 14px;
}
</style>
<section class="home-two-slide home-two d-flex align-items-center" style="background-image: url(assets/img/banner.png);">
    <div class="container">
        <div class="row align-items-center">
            @php
            $become_an_instructor_videos = Helper::become_an_instructor_videos();
            @endphp
            @if($become_an_instructor_videos)

            <div class="col-lg-6 col-12" data-aos="fade-up">
                <div class="home-slide-face">
                    <div class="home-slide-text ">
                        <h5>Latogo</h5>
                        <h1>{{ $become_an_instructor_videos->title }}</h1>
                    </div>
                    <div class="trust-user-two">
                        <p>{{ $become_an_instructor_videos->description }}
                        </p>

                    </div>
                    <div class="all-btn all-category d-flex align-items-center mt-3">
                        <a href="{{ route('teacher.create') }}" class="btn btn-primary">Become a Teacher</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <iframe style="z-index: 9;position: relative;" width="100%" height="315" src="{{ $become_an_instructor_videos->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            @else
            <h1>No Data Found</h1>
            @endif
        </div>
        <div class="shapes">
            <img class="shapes-one" src="assets/img/bg/home-right.png" alt="">
            <img class="shapes-two" src="assets/img/bg/home-right-bottom.png" alt="">
            <img class="shapes-middle" src="assets/img/bg/home-middle.png" alt="">
            <img class="shapes-four wow animate__animated animate__slideInLeft" src="assets/img/bg/home-left.png" alt="">
        </div>

    </div>
</section>
<section class="section home-two" style="padding: 100px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 order-lg-2 order-xs-1 order-sm-1">
                <div class="home-three-head">
                    <h2 class="text-center pb-5">Why become an online teacher with Latogo?
                    </h2>
                </div>
                <div class="stylist-gallery">
                    <div class="row">
                        @php
                        $become_an_instructors = Helper::become_an_instructors();
                        @endphp
                        @if($become_an_instructors)

                        @foreach($become_an_instructors as $become)
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <div class="about-image count-four d-flex align-items-center justify-content-center flex-fill project-details">
                                <div class="about-count">
                                    <div class="course-img">
                                        <img src="{{asset('uploads/become_an_instructors/'.$become->image)}}" alt="">
                                    </div>
                                    <div class="count-content-three course-count ms-0">
                                        <h4><span class="">{{ $become->title }}</span></h4>
                                        <p class="mb-0">{{ $become->description }}</p>

                                        </p>
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
                            <a href="instructor-list.html">
                                <img class="img-fluid" alt="" src="{{asset('uploads/head/'.$he->image)}}">
                            </a>

                        </div>
                        <div class="course-details-two">
                            <div class="instructors-content text-center">
                                <h5><a href="instructor-profile.html">{{$he->name}}</a></h5>
                                <p>{{$he->short_description}}</p>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <h1>No data found</h1>
                @endif
                {{--<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12" data-aos="fade-up">
                    <div class="instructors-widget">
                        <div class="instructors-img">
                            <a href="instructor-list.html">
                                <img class="img-fluid" alt="" src="assets/img/instructor/instructor-02.jpg">
                            </a>

                        </div>
                        <div class="course-details-two">
                            <div class="instructors-content text-center">
                                <h5><a href="instructor-profile.html">Claudia</a></h5>
                                <p>I possess 15 years of experience and my passion is to help students learn German language in a fun and easy way. I have gained professional expertise in German language through accomplishing foreign language certifications, internships, and teaching experience in Germany's biggest institute.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12" data-aos="fade-up">
                    <div class="instructors-widget">
                        <div class="instructors-img">
                            <a href="instructor-list.html">
                                <img class="img-fluid" alt="" src="assets/img/instructor/instructor-03.jpg">
                            </a>

                        </div>
                        <div class="course-details-two">
                            <div class="instructors-content text-center">
                                <h5><a href="instructor-profile.html">Olivia</a></h5>
                                <p>I am a professional tutor and have been working in this field for several years now. I love my job to develop students’ proficiency in the German language, introduce them to different German- speaking cultures, and prepare students for different career prospects.</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12" data-aos="fade-up">
                    <div class="instructors-widget">
                        <div class="instructors-img">
                            <a href="instructor-list.html">
                                <img class="img-fluid" alt="" src="assets/img/instructor/instructor-04.jpg">
                            </a>

                        </div>
                        <div class="course-details-two">
                            <div class="instructors-content text-center">
                                <h5><a href="instructor-profile.html">Katha</a></h5>
                                <p>I have 10 years of teaching experience in German language. My desire to explore different cultures and Latin American studies has piqued more interest for German language over years. Now, I love to share this knowledge to the students.</p>
                            </div>

                        </div>
                    </div>
                </div>--}}
            </div>
        </div>

        @endsection

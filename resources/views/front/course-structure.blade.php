@extends('layouts.dashboard.master2')
@section('content')
<style>
    .faq-card {
        margin-bottom: 15px !important;
    }
    .faq-detail{
        overflow: auto;
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
                                    <li class="breadcrumb-item">All courses</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <section class="share-knowledge-five">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 " data-aos="fade-right">
                            <div class="section-five-sub">
                                <div class="section-sub-head mb-4">
                                    @php
                                        $data = Helper::getCourseBanner();
                                    @endphp
                                    <span class="tagline">All courses</span>
                                    <h2>{{$data->title}}</h2>
                                </div>
                                {{--<div class="career-five-content mb-4">
                                    <p>Mauris ligula dui, gravida rutrum mauris sed, faucibus volutpat nisi. Proin
                                        aliquam lacinia mauris, hendrerit tristique urna molestie quis. Morbi sed
                                        vulputate nisi.</p>
                                </div>
                                <div class="knowledge-list-five">
                                    <ul>
                                        <li class="mb-2">
                                            <div class="knowledge-list-group">
                                                <img src="assets/img/icon/award-new.svg" alt="">
                                                <p class="blue-bold-upper">Reading Classes</p>
                                            </div>
                                        </li>
                                        <li class="mb-2">
                                            <div class="knowledge-list-group">
                                                <img src="assets/img/icon/award-new.svg" alt="">
                                                <p class="blue-bold-upper">Listening Classes</p>
                                            </div>
                                        </li>
                                        <li class="mb-2">
                                            <div class="knowledge-list-group">
                                                <img src="assets/img/icon/award-new.svg" alt="">
                                                <p class="blue-bold-upper">Writing Classes</p>
                                            </div>
                                        </li>
                                        <li class="mb-0">
                                            <div class="knowledge-list-group">
                                                <img src="assets/img/icon/award-new.svg" alt="">
                                                <p class="blue-bold-upper">Speaking Classes</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>--}}
                                    <p>{!!$data->description!!}</p>
                                <div class="all-btn all-category d-flex align-items-center mt-3">
                                @if(Auth::user() && Auth::user()->user_type == 2)@else
                                    @if(Auth::user() != null)
                                    <a href="{{url('/student/student-book-a-class')}}" class="btn btn-primary">Get started</a>
                                    @else
                                    <a href="{{url('/user/login')}}" class="btn btn-primary">Get started</a>
                                    @endif
                                @endif
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 " data-aos="fade-left">
                            <div class="joing-count-five text-center">
                                <img src="{{asset('uploads/courses/'.$data->image)}}" alt="">
                                <div class="joing-count-five-one course-count">
                                    <h3 class="joing-count-number"><span class="counterUp">{{$data->course}}</span>K<span>+</span></h3>
                                    <p class="joing-count-text">Courses</p>
                                </div>
                                <div class="joing-count-five-two course-count">
                                    <h3 class="joing-count-number"><span class="counterUp">{{$data->appreciations}}</span>K</h3>
                                    <p class="joing-count-text">Appreciations</p>
                                </div>
                                <div class="joing-count-five-three course-count">
                                    <h3 class="joing-count-number"><span class="counterUp">{{$data->country}}</span></h3>
                                    <p class="joing-count-text">Countries</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="topcategory-sec new-course next-before-60n" >
                <div class="container">
                    <div class="header-two-title text-center aos aos-init aos-animate" data-aos="fade-up">
                        <!--<p class="tagline">Favourite Course</p>-->
                        <h2 class="mb-2">Course Levels & Standard Duration</h2>
                        <div class="header-two-text">
                            <p class="mb-5">It depends on how you can inculcate and get command of fluency.</p>
                        </div>
                    </div>
                    <div class="top-category-group mb-3" data-aos="fade-up">
                        <div class="row">
                        @php
                            $level = Helper::getCourseLevel();
                        @endphp
                        @if($level)
                        @foreach($level as $le)
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 d-flex aos-init aos-animate"
                                data-aos="fade-down">
                                <div class="categories-item flex-fill">

                                    <div class="categories-content">
                                        <h3>{{$le->level}}</h3>
                                        <p>{{$le->week}} Weeks</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                        <h1>No Data Found</h1>
                        @endif
                            {{--<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 d-flex aos-init aos-animate"
                                data-aos="fade-down">
                                <div class="categories-item flex-fill">

                                    <div class="categories-content">
                                        <h3>A 1.2</h3>
                                        <p>4 Weeks</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 d-flex aos-init aos-animate"
                                data-aos="fade-down">
                                <div class="categories-item flex-fill">

                                    <div class="categories-content">
                                        <h3>A 2.1</h3>
                                        <p>4 Weeks</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 d-flex aos-init aos-animate"
                                data-aos="fade-down">
                                <div class="categories-item flex-fill">

                                    <div class="categories-content">
                                        <h3>A 2.2</h3>
                                        <p>4 Weeks</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 d-flex aos-init aos-animate"
                                data-aos="fade-down">
                                <div class="categories-item flex-fill">

                                    <div class="categories-content">
                                        <h3>B 1.1</h3>
                                        <p>4 Weeks</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 d-flex aos-init aos-animate"
                                data-aos="fade-down">
                                <div class="categories-item  flex-fill">

                                    <div class="categories-content">
                                        <h3>B 1.2</h3>
                                        <p>4 Weeks</p>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>

                    <!-- <div class="col-lg-12">
                        <div class="all-btn all-category d-flex align-items-center justify-content-center">
                            <a href="#" class="btn btn-primary btn-filled">View more details</a>
                        </div>
                    </div> -->

                </div>
            </section>
            <div class="help-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12" >
                            <div class="help-title text-center" data-aos="fade-up">
                                <h1>What are you going to learn?</h1>
                                <p>Here are the most frequently asked questions you may check before getting started</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                        @php
                            $faq = Helper::getCourseFaq();
                        @endphp
                        @if($faq)
                        @foreach($faq as $fa)
                            <div class="faq-card" data-aos="fade-up">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faq{{$fa->id}}"
                                        aria-expanded="false">{{$fa->title}}</a>
                                </h6>
                                <div id="faq{{$fa->id}}" class="collapse">
                                    <div class="faq-detail">
                                        <p>{!!$fa->short_description!!}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <h1>No Data Found</h1>
                            @endif
                            {{--<div class="faq-card" data-aos="fade-up">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo"
                                        aria-expanded="false">Level A1.2</a>
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
                            <div class="faq-card" data-aos="fade-up">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqthree"
                                        aria-expanded="false">Level A2.1</a>
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
                            <div class="faq-card" data-aos="fade-up">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqfour"
                                        aria-expanded="false">Level A2.2</a>
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
                            <div class="faq-card" data-aos="fade-up">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqfive"
                                        aria-expanded="false">Level B1.1</a>
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
                            <div class="faq-card" data-aos="fade-up">
                                <h6 class="faq-title">
                                    <a class="collapsed" data-bs-toggle="collapse" href="#faqsix"
                                        aria-expanded="false">Level B1.2</a>
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
            <section class="section latest-blog download-lesson-sec">
                <div class="container">
                    <div class="section-header aos" data-aos="fade-up">
                        <div class="section-sub-head feature-head text-center mb-0">
                            <h2>Learn a language you can use</h2>
                            <div class="section-text aos" data-aos="fade-up">
                                <p class="mb-0">Discover German cultures and build careers faster than you expect. Go through German language course catalogues and narrow down the course modules that interest you. Join us to learn German online with native teachers by upgrading 100% practical skills and gathering comprehensive experience with the real world.
                                </p>
                            </div>
							<!-- <p class="fw-bold pt-2 aos" data-aos="fade-up">Not listed below? <a class="theme-rose" data-bs-toggle="modal" data-bs-target="#requestpop" href="#">Request here</a></p> -->
                        </div>
                    </div>
                    <div class="owl-carousel blogs-slide owl-theme aos" data-aos="fade-up">
                    @php
                        $lession = Helper::getCourseLession();
                    @endphp
                    @if($lession)
                    @foreach($lession as $les)
                        <div class="instructors-widget blog-widget">
                            <div class="instructors-img">
                                <a href="#">
                                    <img class="img-fluid" alt="" src="{{asset('uploads/course_lessions/'.$les->image)}}">
                                </a>
								 <h5><a href="#">{{$les->title}}</a></h5>
                            </div>
                            <div class="instructors-content text-center">
                                <p>{{$les->description}}</p>
                                <div class="student-count d-flex justify-content-center">
                                    <div
                                        class="all-btn all-category d-flex align-items-center justify-content-center mx-0">
                                        <a  href="uploads/course_lessions/{{$les->lession}}" download="{{$les->lession}}" class="btn btn-primary btn-filled">Download lesson</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <h1>No Data Found</h1>
                    @endif
                        {{--<div class="instructors-widget blog-widget">
                            <div class="instructors-img">
                                <a href="#">
                                    <img class="img-fluid" alt="" src="assets/img/blog/blog-01.jpg">
                                </a>
								 <h5><a href="#">Attract More Attention Sales And Profits</a></h5>
                            </div>
                            <div class="instructors-content text-center">
                                <p>Morbi vulputate convallis nibh vel commodo. Donec eu accumsan enim, et tincidunt
                                    nisl.</p>
                                <div class="student-count d-flex justify-content-center">
                                    <div
                                        class="all-btn all-category d-flex align-items-center justify-content-center mx-0">
                                        <a href="#" class="btn btn-primary btn-filled">Download lesson</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="instructors-widget blog-widget">
                            <div class="instructors-img">
                                <a href="#">
                                    <img class="img-fluid" alt="" src="assets/img/blog/blog-02.jpg">
                                </a>
								 <h5><a href="#">Attract More Attention Sales And Profits</a></h5>
                            </div>
                            <div class="instructors-content text-center">
                                <p>Morbi vulputate convallis nibh vel commodo. Donec eu accumsan enim, et tincidunt
                                    nisl.</p>
                                <div class="student-count d-flex justify-content-center">
                                    <div
                                        class="all-btn all-category d-flex align-items-center justify-content-center mx-0">
                                        <a href="#" class="btn btn-primary btn-filled">Download lesson</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="instructors-widget blog-widget">
                            <div class="instructors-img">
                                <a href="#">
                                    <img class="img-fluid" alt="" src="assets/img/blog/blog-03.jpg">
                                </a>
								 <h5><a href="#">Attract More Attention Sales And Profits</a></h5>
                            </div>
                            <div class="instructors-content text-center">
                                <p>Morbi vulputate convallis nibh vel commodo. Donec eu accumsan enim, et tincidunt
                                    nisl.</p>
                                <div class="student-count d-flex justify-content-center">
                                    <div
                                        class="all-btn all-category d-flex align-items-center justify-content-center mx-0">
                                        <a href="#" class="btn btn-primary btn-filled">Download lesson</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="instructors-widget blog-widget">
                            <div class="instructors-img">
                                <a href="#">
                                    <img class="img-fluid" alt="" src="assets/img/blog/blog-04.jpg">
                                </a>
								 <h5><a href="#">Attract More Attention Sales And Profits</a></h5>
                            </div>
                            <div class="instructors-content text-center">
                                <p>Morbi vulputate convallis nibh vel commodo. Donec eu accumsan enim, et tincidunt
                                    nisl.</p>
                                <div class="student-count d-flex justify-content-center">
                                    <div
                                        class="all-btn all-category d-flex align-items-center justify-content-center mx-0">
                                        <a href="#" class="btn btn-primary btn-filled">Download lesson</a>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>

                </div>
            </section>
        </div>


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

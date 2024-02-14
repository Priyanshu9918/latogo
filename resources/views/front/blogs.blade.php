@extends('layouts.dashboard.master2')
@section('content')
<div class="breadcrumb-bar">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-12">
				<div class="breadcrumb-list">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
							<li class="breadcrumb-item">Blogs</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="page-content">
	<section class="course-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="row">
						@if($blogs)
						@foreach($blogs as $blog)
						<div class="col-md-4 col-sm-12">

							<div class="blog grid-blog">
								<div class="blog-image">
									<a href="{{url('/blog-fetch',encrypt(['id'=> $blog->id]))}}"><img class="img-fluid" src="{{asset('uploads/blogs/'.$blog->image)}}" alt="Post Image"></a>
								</div>
								<div class="blog-grid-box">

									<h3 class="blog-title"><a href="{{url('/blog-fetch',encrypt(['id'=> $blog->id]))}}">{{$blog->title}}</a></h3>
									<div class="blog-info clearfix">
										<div class="post-left">
											<ul>
												<li><img class="img-fluid" src="assets/img/icon/icon-22.svg" alt="">{{date('M d, Y', strtotime($blog->created_at))}}</li>
											</ul>
										</div>
									</div>
									<div class="blog-content blog-read">
										<p>{{$blog->short_description}}
										</p>
										<a href="{{url('/blog-fetch',encrypt(['id'=> $blog->id]))}}" class="read-more btn btn-primary">Read
											More</a>
									</div>
								</div>
							</div>

						</div>
						@endforeach
						@else
						<h1>No Blog Found</h1>
						@endif
						{{--<div class="col-md-4 col-sm-12">

									<div class="blog grid-blog">
										<div class="blog-image">
											<a href="blog-details.php"><img class="img-fluid"
													src="assets/img/blog/blog-09.jpg" alt="Post Image"></a>
										</div>
										<div class="blog-grid-box">
											
											<h3 class="blog-title"><a href="blog-details.php">Expand Your Career
													Opportunities With Python</a></h3>
                                                 <div class="blog-info clearfix">
												<div class="post-left">
													<ul>
														<li><img class="img-fluid" src="assets/img/icon/icon-22.svg"
																alt="">May 24, 2022</li>
													</ul>
												</div>
											</div>
											<div class="blog-content blog-read">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus
													hendrerit. Sed egestas, ante et vulputate volutpat, eros pede […]
												</p>
												<a href="blog-details.php" class="read-more btn btn-primary">Read
													More</a>
											</div>
										</div>
									</div>

								</div>
								<div class="col-md-4 col-sm-12">

									<div class="blog grid-blog">
										<div class="blog-image">
											<a href="blog-details.php"><img class="img-fluid"
													src="assets/img/blog/blog-10.jpg" alt="Post Image"></a>
										</div>
										<div class="blog-grid-box">
											
											<h3 class="blog-title"><a href="blog-details.php">Complete PHP Programming
													Career Guideline</a></h3>
													<div class="blog-info clearfix">
												<div class="post-left">
													<ul>
														<li><img class="img-fluid" src="assets/img/icon/icon-22.svg"
																alt="">Jun 14, 2022</li>
													</ul>
												</div>
											</div>
											<div class="blog-content blog-read">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus
													hendrerit. Sed egestas, ante et vulputate volutpat, eros pede […]
												</p>
												<a href="blog-details.php" class="read-more btn btn-primary">Read
													More</a>
											</div>
										</div>
									</div>

								</div>
								<div class="col-md-4 col-sm-12">

									<div class="blog grid-blog">
										<div class="blog-image">
											<a href="blog-details.php"><img class="img-fluid"
													src="assets/img/blog/blog-11.jpg" alt="Post Image"></a>
										</div>
										<div class="blog-grid-box">
											<div class="blog-info clearfix">
												<div class="post-left">
													<ul>
														<li><img class="img-fluid" src="assets/img/icon/icon-22.svg"
																alt="">Sep 18, 2022</li>
													</ul>
												</div>
											</div>
											<h3 class="blog-title"><a href="blog-details.php">Programming Content
													Guideline For Beginners</a></h3>
											<div class="blog-content blog-read">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus
													hendrerit. Sed egestas, ante et vulputate volutpat, eros pede […]
												</p>
												<a href="blog-details.php" class="read-more btn btn-primary">Read
													More</a>
											</div>
										</div>
									</div>

								</div>
								<div class="col-md-4 col-sm-12">

									<div class="blog grid-blog">
										<div class="blog-image">
											<a href="blog-details.php"><img class="img-fluid"
													src="assets/img/blog/blog-12.jpg" alt="Post Image"></a>
										</div>
										<div class="blog-grid-box">
											<div class="blog-info clearfix">
												<div class="post-left">
													<ul>
														<li><img class="img-fluid" src="assets/img/icon/icon-22.svg"
																alt="">Jun 26, 2022</li>
													</ul>
												</div>
											</div>
											<h3 class="blog-title"><a href="blog-details.php">The Complete JavaScript
													Course for Beginners</a></h3>
											<div class="blog-content blog-read">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus
													hendrerit. Sed egestas, ante et vulputate volutpat, eros pede […]
												</p>
												<a href="blog-details.php" class="read-more btn btn-primary">Read
													More</a>
											</div>
										</div>
									</div>

								</div>
								<div class="col-md-4 col-sm-12">

									<div class="blog grid-blog">
										<div class="blog-image">
											<a href="blog-details.php"><img class="img-fluid"
													src="assets/img/blog/blog-13.jpg" alt="Post Image"></a>
										</div>
										<div class="blog-grid-box">
											<div class="blog-info clearfix">
												<div class="post-left">
													<ul>
														<li><img class="img-fluid" src="assets/img/icon/icon-22.svg"
																alt="">Feb 14, 2022</li>
													</ul>
												</div>
											</div>
											<h3 class="blog-title"><a href="blog-details.php">Learn Mobile Applications
													Development from Experts</a></h3>
											<div class="blog-content blog-read">
												<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus
													hendrerit. Sed egestas, ante et vulputate volutpat, eros pede […]
												</p>
												<a href="blog-details.php" class="read-more btn btn-primary">Read
													More</a>
											</div>
										</div>
									</div>

								</div>--}}
					</div>

					{{--<div class="row">
								<div class="col-md-12">
									<ul class="pagination lms-page">
										<li class="page-item prev">
											<a class="page-link" href="javascript:void(0);" tabindex="-1"><i
													class="fas fa-angle-left"></i></a>
										</li>
										<li class="page-item first-page active">
											<a class="page-link" href="javascript:void(0);">1</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="javascript:void(0);">2</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="javascript:void(0);">3</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="javascript:void(0);">4</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="javascript:void(0);">5</a>
										</li>
										<li class="page-item next">
											<a class="page-link" href="javascript:void(0);"><i
													class="fas fa-angle-right"></i></a>
										</li>
									</ul>
								</div>
							</div>--}}

				</div>
			</div>
		</div>
	</section>
	<section class="section latest-blog d-none">
		<div class="container">
			<div class="lab-course">
				<div class="section-header aos" data-aos="fade-up">
					<div class="section-sub-head feature-head text-center">
						<h2>Get 10% Off When you sign up for <br>our newsletter!</h2>
					</div>
				</div>
			</div>
			<div class="enroll-group mt-0 aos" data-aos="fade-up">
				<div class="row ">
					<div class="col-md-12">
						<div class="banner-content m-0">
							<form class="form" name="store" id="store" method="post" action="course-list.html">
								<div class="form-inner mx-auto">
									<div class="input-group">
										<span class="drop-detail m-0">
											<select class="form-control select" name="storeID">
												<option value="0">Select language</option>
												<option value="1">English</option>
												<option value="1">German</option>
											</select>
										</span>
										<input type="email" class="form-control" placeholder="Enter your email id">
										<button class="btn btn-primary sub-btn w-auto" type="submit">Submit</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="py-5">
		<div class="">

		</div>
	</section>
</div>

@endsection

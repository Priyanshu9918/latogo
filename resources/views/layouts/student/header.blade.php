<style>
@media only screen and (max-width: 600px) { 
	.logo{
		margin-left: 50px;
	}
	.navbar-header{
		width: auto;
	}
	.header-navbar-rht {
		display: block;
	}
}
</style>
<?php  $activePage = basename($_SERVER['PHP_SELF'], ".php");  ?>
<header class="header header-page">
	<div class="header-fixed">
		<nav class="navbar navbar-expand-lg header-nav scroll-sticky">
			<div class="container ">
				<div class="navbar-header">
					<a id="mobile_btn" href="javascript:void(0);">
						<span class="bar-icon">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</a>
					  <a href="{{url('/student/my-classes')}}" class="navbar-brand logo">
                        <img src="{{asset('assets/img/latogo_logo.svg')}}" class="img-fluid" alt="Logo">
                    </a>
				</div>
				<div class="main-menu-wrapper">
					<div class="menu-header">
						<a href="{{ url('/student/dashboard') }}" class="menu-logo">
							<img src="{{asset('assets/img/latogo_logo.svg')}}" class="img-fluid" alt="Logo">
						</a>
						<a id="menu_close" class="menu-close" href="javascript:void(0);">
							<i class="fas fa-times"></i>
						</a>
					</div>
					<ul class="main-nav">
						<li class=" {{ request()->is('student/dashboard') ? 'active' : ' ' }}">
                            <a href="{{url('student/dashboard')}}">Today's overview </a>
                        </li>
                        <li class=" {{ request()->is('student/my-classes') ? 'active' : ' ' }}">
                            <a href="{{url('student/my-classes')}}">My classes </a>
                        </li>
                        </li>
                        <li class="  {{ request()->is('student/student-book-a-class') ? 'active' : ' ' }}">
                            <a class="theme-rose fw-bold text-decoration-underline" href="{{url('student/student-book-a-class')}}">Book a class </a>
                        </li>
						<li class=" {{ request()->is('view') ? 'active' : ' ' }}">
                            <a href="{{url('view')}}">Pricing </a>
                        </li> 
						<li class=" {{ request()->is('student/practice') ? 'active' : ' ' }}">
                            <a href="{{url('student/quize')}}">Practice </a>
                        </li>
						@if(Auth::check() && Auth::user()->user_type == 1)
                            <li class="login-link">
                                <a href="{{url('student/my-classes')}}">Dashboard </a>
                            </li>
                            <li class="login-link">
                                <a href="{{route('student.logout')}}">Log Out </a>
                            </li>
                        @elseif(Auth::check() && Auth::user()->user_type == 2)
                            <li class="login-link">
                                <a href="{{url('teacher/dashboard')}}">Dashboard </a>
                            </li>
                            <li class="login-link">
                               <a href="{{ route('logout') }}">Log Out </a>
                            </li>
                        @else
                            <li class="login-link">
                                <a href="{{url('/user/login')}}">Login / Signup</a>
                            </li>
                        @endif
                    </ul>
				</div>
				<ul class="nav header-navbar-rht">
					<li class="nav-item">
						<a href="{{ url('/chatify') }}">
							<span class="cart-item-count head-chat-count" style="left: -10px">{{ Helper::msgCount(); }}</span>
                            <img src="{{asset('assets/img/icon/messages.svg')}}" alt="img">
                        </a>
					</li>
					<li class="nav-item wish-nav">
						<a href="{{route('student.wish.list')}}" >
						
							<img src="{{asset('assets/img/icon/wish.svg')}}" alt="img">
						</a>
					</li>

					<li class="nav-item user-nav">
						<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
						<?php
							$user_id = Auth::user()->id;
							$wish = DB::table('wishlists')->where('user_id', $user_id)->get()->count();
							?>
							<span class="cart-item-count wishlist-item-count">
										{{ $wish }}	
											</span>
							<span class="user-img">
							@php 
								$user_id = Auth::user()->id;
								$student1 = DB::table('student_details')->where('user_id',$user_id)->first();
							@endphp
							@if(isset($student1->avtar))
							<img src="{{asset('uploads/user/avatar/'.$student1->avtar)}}" alt="User Image"
									class="avatar-img rounded-circle">
							@else
							<img src="{{asset('assets/img/user/user.png')}}" alt="User Image"
							class="avatar-img rounded-circle">
							@endif
								<span class="status online"></span>
							</span>
						</a>
						<div class="users dropdown-menu dropdown-menu-right" data-popper-placement="bottom-end">
							<div class="user-header">
								<div class="avatar avatar-sm">
								@php 
									$user_id = Auth::user()->id;
									$student1 = DB::table('student_details')->where('user_id',$user_id)->first();
								@endphp
								@if(isset($student1->avtar))
								<img src="{{asset('uploads/user/avatar/'.$student1->avtar)}}" alt="User Image"
										class="avatar-img rounded-circle">
								@else
								<img src="{{asset('assets/img/user/user.png')}}" alt="User Image"
								class="avatar-img rounded-circle">
								@endif
								</div>
								<div class="user-text">
									<h6>{{Auth::user()->name}}</h6>
									<p class="text-muted mb-0">Student</p>
								</div>
							</div>
							<a class="dropdown-item" href="{{url('student/refer-a-friend')}}">
								<i class="feather-home me-1"></i> Refer a friend</a>
							<a class="dropdown-item" href="{{url('chatify/1')}}"><i
									class="feather-headphones me-1"></i> Support</a>
							<a class="dropdown-item" href="{{url('student/student-settings')}}"><i
									class="feather-settings me-1"></i> Settings</a>

							<a class="dropdown-item" href="{{route('student.logout')}}"><i class="feather-log-out me-1"></i>
								Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</div> 
</header>
<input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" />
<input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
<input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />
@push('script')

	<script>
		$(document).ready(function(){
			checkMsg();

			
		});
	</script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{ asset('assets/js/chat.js') }}"></script>
    @if(request()->has('user') && request()->get('user')!='')
        <script>
            var user_id = "{{ request()->get('user') }}";
            $( window ).on('load',function(){
                $('.chat-toggle').each(function(index, currentElement) {
                    if($(this).data('id')==user_id)
                    {
                        $(this).click();
						return true;
                    }
                });
            })
        </script>
    @else
    <script>
        $( window ).on('load',function(){
            $('.chat-toggle').each(function(index, currentElement) {
                    $(this).click();
                    return true;
            });
        })
    </script>
    @endif
	
@endpush
<!-- <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script> -->


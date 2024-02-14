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
<?php  $activePage = Request::segment(2);  ?>
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
					<a href="{{ url('/teacher/dashboard') }}" class="navbar-brand logo">
						<img src="{{ asset('assets/img/latogo_logo.svg') }}" class="img-fluid" alt="Logo">
					</a>
				</div>
				<div class="main-menu-wrapper">
					<div class="menu-header">
						<a href="{{ url('/') }}" class="menu-logo">
							<img src="{{ asset('assets/img/latogo_logo.svg') }}" class="img-fluid" alt="Logo">
						</a>
						<a id="menu_close" class="menu-close" href="javascript:void(0);">
							<i class="fas fa-times"></i>
						</a>
					</div>
					<ul class="main-nav">
                        <li class=" <?= ($activePage == 'dashboard') ? ' active':'' ?>">
                            <a class="" href="{{ route('teacher.dashboard') }}">Teacher Dashboard </a>
                        </li>

                        </li>
                        <li class=" <?= ($activePage == 'setting') ? ' active':'' ?>">
                            <a href="{{ route('teacher.setting') }}">Teacher Settings </a>
                        </li>
						<li class=" <?= ($activePage == 'calendar') ? ' active':'' ?>">
                            <a href="{{ route('teacher.calendar') }}">My calendar </a>
                        </li>
						<li class=" <?= ($activePage == 'chatify') ? ' active':'' ?>">
                            <a href="{{ url('/chatify') }}">Messages </a>
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
						<span class="cart-item-count head-chat-count" style="left: -10px">{{ Helper::msgCount(); }}</span>
						<!-- <a href="{{ route('teacher.messages') }}"><img src="{{ asset('assets/img/icon/messages.svg') }}" alt="img"></a> -->
						<a href="{{ url('/chatify') }}"><img src="{{ asset('assets/img/icon/messages.svg') }}" alt="img"></a>
					</li>
					<li class="nav-item user-nav">
						<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
							<span class="user-img">
                                @if(auth()->user()->TeacherSetting!=null && auth()->user()->TeacherSetting->avatar && File::exists(public_path('uploads/user/avatar/'.auth()->user()->TeacherSetting->avatar)))
								    <img src="{{ asset('uploads/user/avatar/'.auth()->user()->TeacherSetting->avatar) }}" alt="">
                                @else
                                    <img src="{{ asset('assets/img/user/user.png') }}" alt="">
                                @endif
								<span class="status online"></span>
							</span>
						</a>
						<div class="users dropdown-menu dropdown-menu-right" data-popper-placement="bottom-end">
							<div class="user-header">
								<div class="avatar avatar-sm">
									{{-- <img src="{{ asset('assets/img/instructor/profile-avatar.jpg') }}" alt="User Image" class="avatar-img rounded-circle"> --}}
                                    @if(auth()->user()->TeacherSetting!=null && auth()->user()->TeacherSetting->avatar && File::exists(public_path('uploads/user/avatar/'.auth()->user()->TeacherSetting->avatar)))
                                        <img src="{{ asset('uploads/user/avatar/'.auth()->user()->TeacherSetting->avatar) }}" class="avatar-img rounded-circle" alt="">
                                    @else
                                        <img src="{{ asset('assets/img/user/user.png') }}" class="avatar-img rounded-circle" alt="">
                                    @endif

								</div>
								<div class="user-text">
									<h6>{{ Auth::user()->name }}</h6>
									<p class="text-muted mb-0">Professional Teacher</p>
								</div>
							</div>
							<a class="dropdown-item" href="{{ route('teacher.dashboard') }}"><i
									class="feather-home me-1"></i> Dashboard
                            </a>
							<a class="dropdown-item" href="{{ route('teacher.setting') }}"><i
									class="feather-star me-1"></i> Edit Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="feather-log-out me-1"></i>
								Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>

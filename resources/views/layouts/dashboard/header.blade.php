<?php  $activePage = basename($_SERVER['PHP_SELF'], ".php");  ?>
<style>
/* Style The Dropdown Button */
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}

</style>
<header class="header <?= ($activePage == 'index') ? ' ':'header-page' ?>">
    <div class="header-fixed">
        <nav class="navbar navbar-expand-lg header-nav scroll-sticky">
            <div class="container">
                <div class="navbar-header">
                    <a id="mobile_btn" href="javascript:void(0);">
                        <span class="bar-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </a>
                    <a href="{{url('/')}}" class="navbar-brand logo">
                        <img src="{{asset('assets/img/latogo_logo.svg')}}" class="img-fluid" alt="Logo">
                    </a>
                </div>
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="{{url('/')}}" class="menu-logo">
                            <img src="{{asset('assets/img/latogo_logo.svg')}}" class="img-fluid" alt="Logo">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <ul class="main-nav">
                        <li class=" {{ request()->is('/') ? 'active' : ' ' }}">
                            <a class="" href="{{url('/')}}">Home </a>
                        </li>
                        <li class=" {{ request()->is('about') ? 'active' : ' ' }}">
                            <a href="{{url('/about')}}">About us</a>
                        </li>
                        <li class=" {{ request()->is('course-structure') ? 'active' : ' ' }}">
                            <a href="{{url('course-structure')}}">All Courses </a>
                        </li>
                        <li class=" {{ request()->is('view') ? 'active' : ' ' }}">
                            <a href="{{url('view')}}">Pricing </a>
                        </li> 
                        <li class=" {{ request()->is('blog') ? 'active' : ' ' }}">
                            <a href="{{url('blog')}}">Blogs  </a>
                        </li>
                        <li class="{{ request()->is('support') ? 'active' : ' ' }}">
                            <a href="{{url('support')}}">FAQs</a>
                        </li> 
                        <li style="line-height: 70px;">
                            <!-- <select name="currency" id="currency" style="color: #000;">
                                <option @if(Session::get('currency') == 'USD') selected @endif value="USD">USD</option>
                                <option @if(Session::get('currency') == 'EUR') selected @endif value="EUR">EUR</option>
                            </select> -->
                            <!-- <div class="dsdropdown d-none" style="background: #fff;line-height: 15px;margin-top: 15px;position: relative;">
                                <button class="btn langbtn" type="button"> 
                                @if(Session::get('currency') == 'EUR')
                                    <span class="lang-change"> <img src="{{asset('assets/img/germany-flag.webp')}}" width="20" height="15"> EUR </span>
                                @else
                                    <span class="lang-change"> <img src="{{asset('assets/img/usa-flag.webp')}}" width="20" height="15"> USD </span>
                                @endif
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dsdropdown-menu" style="">
                                    <li class="dsdropdown-item selectlang" style="line-height: 0;margin: 5px 0px;padding: 5px 0px;" onclick="changeLanguage('en')" data-value="USD" id="currency">
                                      <img src="{{asset('assets/img/usa-flag.webp')}}" width="20" height="15"> USD
                                    </li>
                                    <li class="dsdropdown-item selectlang" style="line-height: 0; margin: 5px 0px;padding: 5px 0px;" onclick="changeLanguage('fr')" data-value="EUR" id="currency">
                                      <img src="{{asset('assets/img/germany-flag.webp')}}" width="20" height="15"> EUR
                                    </li>
                                </ul>
                            </div> -->
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
                        <!-- <li class="">
                            <select name="currency" id="currency" style="background: #4c52e1; color: #fff;">
                                <option @if(Session::get('currency') == 'USD') selected @endif value="USD">USD</option>
                                <option @if(Session::get('currency') == 'EUR') selected @endif value="EUR">EUR</option>
                            </select>
                        </li> -->
                        @if(Auth::check() && Auth::user()->user_type == 1)
                            <li class=" ">
                                <a href="{{url('student/my-classes')}}">Dashboard </a>
                            </li>
                            <li class=" ">
                                <a href="{{route('student.logout')}}">Log Out </a>
                            </li>
                        @elseif(Auth::check() && Auth::user()->user_type == 2)
                            <li class=" ">
                                <a href="{{url('teacher/dashboard')}}">Dashboard </a>
                            </li>
                            <li class=" ">
                                <a href="{{ route('logout') }}">Log Out </a>
                            </li>
                        @else
                        </ul>
                        <ul class="nav header-navbar-rht">
                            <li class="nav-item">
                                <a class="nav-link header-sign" href="{{url('/user/login')}}">LOG IN </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link header-login" href="{{url('student/register')}}">REGISTER</a>
                            </li>
                        </ul>
                @endif
            </div>
        </nav>
    </div>
</header>
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
        $(document).on('click', '#currency', function () {
            // var currency = $('#currency').val();
            var currency = $(this).attr('data-value'); 
            // alert(currency);
            $.ajax({
                url: "{{ route('currency_changes') }}",
                type: "get",
                data: {
                    'currency': currency,
                },
                success: function(response) {
                    if(response.success==true) {
                        location.reload();
                    }
                }
            });
        });
        function changeLanguage(lang){
            //window.location ='change-language/'+lang;
        }
        $(document).ready(function(){
            //show dropdown Menu on click
            $(".langbtn").click(function(){
              $('.langbtn ~ .dsdropdown-menu').toggle();
            });
            //On select language pick there inner html and put in dt variable and print inside the button and hide dropdown menu
            $(".selectlang").click(function(){
              var dt = $(this).html();
              $('.lang-change').html(dt);
              $('.langbtn ~ .dsdropdown-menu').hide();
            });
          });
</script>


<footer class="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                    @php
                $footer = Helper::footer();
                @endphp
                @if($footer)
                <div class="col-lg-4 col-md-6">

                    <div class="footer-widget footer-about">
                        <div class="footer-logo">
                            <a href="{{url('/')}}"><img src="{{asset('assets/img/latogo_logo.svg')}}" alt="logo"></a>
                        </div>
                        <div class="footer-about-content">
                            <p>{!! $footer->description !!}</p>
                        </div>
                    </div>
                </div>
                @else
                <h1>No Data Found</h1>
                @endif
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Useful links</h2>
                        <ul>
                            @if(Auth::user() != null)
                            @if(Auth::user()->user_type == 1)
                            <li><a href="{{url('/student/setting')}}">Profile</a></li>
                            @else
                            <li><a href="{{url('/teacher/setting')}}">Profile</a></li>
                            @endif
                            @endif
                            <li><a href="{{url('/course-structure')}}">Course Structure</a></li>
                            <li><a href="{{url('/view')}}">Pricing</a></li>
                            <li><a href="{{url('/blog')}}"> Blogs</a></li>
                            <li><a href="{{url('/support')}}"> Contact us</a></li>
                        </ul>
                    </div>
                </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="footer-widget footer-menu">
                                <h2 class="footer-title"></h2>
                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">

                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Contact us</h2>

                        <!-- <div class="footer-contact-info">
                            <div class="footer-address">
                                <img src="{{asset('assets/img/icon/icon-20.svg')}}" alt="" class="img-fluid">
                                <p> Sepapaja tn 6 Lasnamäe linnaosa ,<br> 15551 Tallinn </p>
                            </div>
                           <p>
                                <img src="{{asset('assets/img/icon/icon-19.svg')}}" alt="" class="img-fluid">
                                <a href="mailto:hallo@latogo.de" class="" > hallo@latogo.de</a>
                            </p>
                            <p class="mb-0">
                                <img src="{{asset('assets/img/icon/icon-21.svg')}}" alt="" class="img-fluid">
                             <a href="tel:+37281597480"> +37281597480 </a>
                            </p>
                        </div> -->
                        <div class="footer-contact-info">
                            <div class="footer-address">
                                <img src="{{asset('assets/img/icon/icon-20.svg')}}" alt="" class="img-fluid">
                                <p> {{$footer->address ?? ''}}</p>
                            </div>
                            <p>
                                <img src="{{asset('assets/img/icon/icon-19.svg')}}" alt="" class="img-fluid">
                                <a href="mailto:{{$footer->email ?? '' }}" class="" > {{$footer->email ?? ''}}</a>
                            </p>
                            <p class="mb-0">
                                <img src="{{asset('assets/img/icon/icon-21.svg')}}" alt="" class="img-fluid">
                                <a href="tel:+{{$footer->phone ?? '' }}"> +{{$footer->phone ?? '' }} </a>
                            </p>
                        </div>
                    </div>

                </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="privacy-policy">
                                    <ul>
                                    <li><a href="{{url('terms-conditions')}}">Terms</a></li>
                                    <li><a  href="{{url('privacy-policy')}}">Privacy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="copyright-text">
                                    <p class="mb-0">&copy; 2023 Latogo. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

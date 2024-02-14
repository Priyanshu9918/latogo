<footer class="footer">
    <div class="footer-top aos" data-aos="fade-up">
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
                            <li><a href="{{url('/student/student-settings')}}">Profile</a></li>
                            @else
                            <li><a href="{{url('/teacher/teacher-settings')}}">Profile</a></li>
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
                        <h2 class="footer-title">For Student</h2>
                        <ul>
                            <li><a href="{{url('student/dashboard')}}"> Today's Overview</a></li>
                            <li><a href="{{url('/student/student-book-a-class')}}">Book a Class</a></li>
                            <li><a href="{{url('student/my-classes')}}">My Class</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Contact us</h2>

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
        <div class="container ">
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
                            <p class="mb-0">© 2023 Latogo. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
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
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModalll">
    Launch demo modal
  </button>
  
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

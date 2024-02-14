<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="overflow-x: scroll;">
          <div class="app-brand demo">
            <a href="{{url('admin/dashboard')}}" class="app-brand-link">
            <img src="{{asset('assets/img/latogo_logo.svg')}}" style="width: 50%; left: 50px; position: relative;" alt="Logo">
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle closeds menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : ' ' }}">
              <a href="{{url('admin/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('admin/student') || request()->is('admin/student/*') ? 'active' : ' ' }}">
              <a href="{{url('admin/student')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Manage Student</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('admin/teacher') || request()->is('admin/teacher/*') ? 'active' : ' ' }}">
              <a href="{{url('admin/teacher')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Manage Teacher</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('admin/quize') || request()->is('admin/quize/*') ? 'active' : ' ' }}">
              <a href="{{url('admin/quize')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Manage Quiz Test</div>
              </a>
            </li>
            <!-- Layouts -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage Home</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('admin/banner')}}" class="menu-link ">
                    <div data-i18n="Basic Inputs"> Manage Banner</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/banner_point')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Banner Point</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('admin.View_bottom_banner') }}" class="menu-link">
                    <div data-i18n="Input groups">Manage Bottom Banner</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/resion')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Resion Of Best</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/category_class')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Class Category</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/bookclasses')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Book a class</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/what-new')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage What's New</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/whats-new-point')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage What's New Point</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/client')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Client</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/video')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Student Videos</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/faq')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Faq's</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/testimonials')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Testimonials</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/short_banners')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Become An Instructor</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{url('admin/transform_short_banners')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Transform Access To Education</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/education_info')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Education Info</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/footer_texts')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Footer Text</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/student_login')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Student Login Page</div>
                  </a>
                </li>

              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage Blogs</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('/admin/blog/create')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Add Blog</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/blog')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Blogs</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage About Us</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{url('admin/about')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage About Us</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/why-we')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Why We</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/head')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Head Instructor</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage Pricing</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{url('admin/price-master')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage price Master</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/pricing')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage pricing</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/trial_classes')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Trial Class</div>
                    </a>
                </li>
                  <li class="menu-item">
                  <a href="{{url('admin/review')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Review</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage Become An Instructors</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('admin/become_an_instructor_videos')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manange Become An Instructor Videos</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/become_an_instructors')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Become An Online Teacher</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage Contact</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item">
                  <a href="{{url('admin/contact_videos')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manange Contact Video</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/contact_titles')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Contact Title</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/contact_queries')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manange Contact Query</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Manage All Courses</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{url('admin/course')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Banner</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/course_level')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Course Level</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/course_faq')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Course Faq's</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{url('admin/course_lession')}}" class="menu-link">
                    <div data-i18n="Basic Inputs">Manage Course Lesson</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Referral Management</div>
              </a>
              <ul class="menu-sub">
              <li class="menu-item {{ request()->is('admin/referral') ? 'active' : ' ' }}">
              <a href="{{url('admin/referral')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Referral Coupon</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('admin/coupon') ? 'active' : ' ' }}">
              <a href="{{url('admin/coupon')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Referral history</div>
              </a>
            </li>
              </ul>
            </li>
            <li class="menu-item {{ request()->is('admin/view-orders') ? 'active' : ' ' }}">
              <a href="{{route('admin.view_order')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Manage order</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('admin/view-book-sessions') ? 'active' : ' ' }}">
              <a href="{{url('admin/view-book-sessions')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Manage Booking Sessions</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('admin/cms') ? 'active' : ' ' }}">
              <a href="{{url('admin/cms')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Manage CMS</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('chatify') ? 'active' : ' ' }}">
                <a href="{{url('chatify')}}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-user"></i>
                  <div data-i18n="Analytics">Support Messages</div>
                </a>
              </li>
          </ul>
        </aside>

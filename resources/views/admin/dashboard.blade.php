@extends('layouts.admin.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <!-- <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Congratulations John! 🎉</h5>
                          <p class="mb-4">
                            You have done <span class="fw-bold">72%</span> more Courses today. Check your new badge in
                            your profile.
                          </p> -->

                          <!-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Course</a> -->
                        <!-- </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="col-lg-12 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-3 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../admin/assets/img/icons/unicons/std.png"
                                alt="chart success"
                                class="rounded"
                              />
                            </div>
                          </div>
                          <a href="{{url('/admin/student')}}">
                          <span class="fw-semibold d-block mb-1">Total Students</span>
                          @php
                            $student = DB::table('users')->where('user_type',1)->where('status','<>',2)->get();
                            $student1 = DB::table('users')->where('user_type',1)->where('status',1)->get();
                            $student2 = DB::table('users')->where('user_type',1)->where('status',0)->get();
                          @endphp
                          <h3 class="card-title mb-2">{{count($student)}}</h3>
                          <div class=''>
                          <small class="text-dark fw-semibold"><span style="color:darkgreen;">Active - </span>{{count($student1)}}</small>
                          </div>
                          <div class=''>
                          <small class="text-dark fw-semibold"><span style="color:darkgreen;">Inactive - </span>{{count($student2)}}</small>
                          </div>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../admin/assets/img/icons/unicons/tea.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                          </div>
                          <a href="{{url('/admin/teacher')}}">
                          <span class="fw-semibold d-block mb-1">Total Teachers</span>
                          @php
                            $teacher = DB::table('users')->where('user_type',2)->where('status','<>',2)->get();
                            $teacher1 = DB::table('users')->where('user_type',2)->where('status',1)->get();
                            $teacher2 = DB::table('users')->where('user_type',2)->where('status',0)->get();
                          @endphp
                          <h3 class="card-title text-nowrap mb-1">{{count($teacher)}}</h3>
                          <div class=''>
                          <small class="text-dark fw-semibold"><span style="color:darkgreen;">Active - </span>{{count($teacher1)}}</small>
                          </div>
                          <div class=''>
                          <small class="text-dark fw-semibold"><span style="color:darkgreen;">Inactive - </span>{{count($teacher2)}}</small>
                          </div>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../admin/assets/img/icons/unicons/cou.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                          </div>
                          <a href="{{url('/admin/bookclasses')}}">
                          <span class="fw-semibold d-block mb-1">Total courses</span>
                          @php
                            $course = DB::table('bookclasses')->where('status','<>',2)->get();
                            $course1 = DB::table('bookclasses')->where('status',1)->get();
                          @endphp
                          <h3 class="card-title text-nowrap mb-1">{{count($course)}}</h3>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../admin/assets/img/icons/unicons/ord.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                          </div>
                          <a href="{{url('/admin/view-orders')}}">
                          <span class="fw-semibold d-block mb-1">Total Bookings</span>
                          @php
                            $order = DB::table('orders')->where('is_completed',1)->get();
                          @endphp
                          <h3 class="card-title text-nowrap mb-1">{{count($order)}}</h3>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-3  col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="../admin/assets/img/icons/unicons/ref.png" alt="Credit Card" class="rounded" />
                            </div>
                          </div>
                          <a href="{{url('/admin/coupon')}}">
                          <span class="d-block mb-1">Total Referee</span>
                          @php
                            $refer = DB::table('records_of_references')->get();
                          @endphp
                          <h3 class="card-title text-nowrap mb-2">{{count($refer)}}</h3>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            @endsection

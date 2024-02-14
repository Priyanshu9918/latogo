<?php  $activePage = basename($_SERVER['PHP_SELF'], ".php");  ?>
<div class="settings-menu">
                                <h3>ACCOUNT SETTINGS</h3>
                                <ul>
                                    <li class="nav-item {{ request()->is('student/student-settings') ? 'active' : ' ' }}">
                                        <a href="{{url('/student/student-settings')}}" class="nav-link">
                                            <i class="feather-settings"></i> Edit Profile
                                        </a>
                                    </li>
                                    <li class="nav-item {{ request()->is('student/student-change-password') ? 'active' : ' ' }}">
                                        <a href="{{url('/student/student-change-password')}}" class="nav-link">
                                            <i class="feather-user"></i> Change Password
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="feather-refresh-cw"></i> Social Profiles
                                        </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="feather-bell"></i> Notifications
                                        </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="feather-lock"></i> Profile Privacy
                                        </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="feather-trash-2"></i> Delete Profile
                                        </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="feather-user"></i> Linked Accounts
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="{{url('student/refer-a-friend')}}" class="nav-link">
                                            <i class="feather-user-plus"></i> Referrals
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('student.logout')}}" class="nav-link">
                                            <i class="feather-power"></i> Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </div>

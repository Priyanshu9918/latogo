@extends('layouts.teacher.master')
@section('content')

    <div class="">
        <section class="page-content course-sec course-message pt-4">
            <div class="container">
            <h2>Messages</h2>
                <div class="student-widget message-student-widget">
                    <div class="student-widget-group">
                        {{-- <div class="col-md-12">
                            <div class="add-compose">
                                <a href="javascript:;" class="btn btn-primary"><i class="fa-solid fa-plus"></i>
                                    Compose
                                </a>
                            </div>
                        </div> --}}
                        <div class="col-md-12 col-lg-8 mx-auto">
                            <div class="chat-window">

                                <div class="chat-cont-left" style="background: #f6697b;">
                                    <div class="chat-users-list">
                                        <p class="m-0" style=" padding-left: 20px; color: #fff;font-weight: 600; text-transform: uppercase;font-size: 14px; padding-top: .5rem!important; padding-bottom: 0.5rem!important;   background: #f6697b;"  >Recent chats</p>
                                        <hr class="my-0">


                                                <div class="chat-scroll" id="users">
                                                    @if($users->count() > 0)
                                                    @foreach($users as $user)
                                                        <a href="javascript:void(0);" class="media d-flex align-items-center chat-toggle" data-id="{{ $user->id }}" data-user="{{ ($user->user_type==0)?'Latogo support':$user->name }}">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    @if($user->user_type==1)
                                                                        @if($user->StudentDetail!=null && $user->StudentDetail->avtar!=null && File::exists(public_path('uploads/user/avatar/'.$user->StudentDetail->avtar)))
                                                                            <img src="{{ asset('uploads/user/avatar/'.$user->StudentDetail->avtar) }}" alt="User Image" class="avatar-img rounded-circle">
                                                                        @else
                                                                            <img src="{{ asset('assets/img/user/user.png') }}" alt="User Image" class="avatar-img rounded-circle">
                                                                        @endif
                                                                    @elseif ($user->user_type==2)
                                                                        @if($user->TeacherSetting!=null && $user->TeacherSetting->avatar!=null && File::exists(public_path('uploads/user/avatar/'.$user->TeacherSetting->avatar)))
                                                                            <img src="{{ asset('uploads/user/avatar/'.$user->TeacherSetting->avatar) }}" alt="User Image" class="avatar-img rounded-circle">
                                                                        @else
                                                                             <img src="{{ asset('assets/img/user/user.png') }}" alt="User Image" class="avatar-img rounded-circle">
                                                                        @endif
                                                                    @else
                                                                        <img src="{{ asset('assets/img/user/user.png') }}" alt="User Image" class="avatar-img rounded-circle">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">{{ ($user->user_type==0)?'Latogo support':$user->name }}</div>
                                                                    {{-- <div class="user-last-chat">how are you?</div> --}}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                    @endif
                                                        {{-- <a href="javascript:void(0);" class="media read-chat active d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-online">
                                                                    <img src="{{ asset('assets/img/user/user2.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">Jenis R. </div>
                                                                    <div class="user-last-chat">i am very well</div>
                                                                </div>
                                                                <div class="badge-active">
                                                                    <div class="badge bgg-yellow badge-pill">1</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media read-chat active d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-online">
                                                                    <img src="{{ asset('assets/img/user/user3.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">Jesse Stevens </div>
                                                                    <div class="user-last-chat">Hai</div>
                                                                </div>
                                                                <div class="badge-active">
                                                                    <div class="badge bgg-yellow badge-pill">1</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media read-chat active d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-online">
                                                                    <img src="{{ asset('assets/img/user/user4.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">Jesse Stevens</div>
                                                                    <div class="user-last-chat">Good morning</div>
                                                                </div>
                                                                <div class="badge-active">
                                                                    <div class="badge bgg-yellow badge-pill">5</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    <img src="{{ asset('assets/img/user/user5.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">John Smith</div>
                                                                    <div class="user-last-chat">how are you?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    <img src="{{ asset('assets/img/user/user6.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">Stella Johnson</div>
                                                                    <div class="user-last-chat">Good morning </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    <img src="{{ asset('assets/img/user/user7.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">John Michael</div>
                                                                    <div class="user-last-chat">i am very well</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    <img src="{{ asset('assets/img/user/user5.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">John Smith</div>
                                                                    <div class="user-last-chat">how are you?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    <img src="{{ asset('assets/img/user/user1.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">Rolands R</div>
                                                                    <div class="user-last-chat">how are you?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0);" class="media d-flex">
                                                            <div class="media-img-wrap flex-shrink-0">
                                                                <div class="avatar avatar-away">
                                                                    <img src="{{ asset('assets/img/user/user5.jpg') }}" alt="User Image"
                                                                        class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="media-body flex-grow-1">
                                                                <div>
                                                                    <div class="user-name">John Smith</div>
                                                                    <div class="user-last-chat">how are you?</div>
                                                                </div>
                                                            </div>
                                                        </a> --}}

                                                </div>

                                    </div>
                                </div>


                                @include('front.teacher.chat-box')

                                <div id="chat-overlay" style="min-height:40vh;" class="chat-cont-parent @if($users->count() <= 0) d-flex justify-content-center align-items-center @endif">
                                    @if($users->count() <= 0)
                                        <div class="text-center ">
                                            <button class="btn btn-primary" onclick="location.href = '?user=1'">Latogo support</button>
                                        </div>
                                    @endif
                                </div>

                                <input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" />
                                <input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
                                <input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section
    </div>

@push('script')
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
@endsection

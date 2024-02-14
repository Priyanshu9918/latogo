@extends('layouts.student.master')
@section('content') 
<style>
    .mw-80 {
        max-width: 80px;
    }
    .student-ticket-view {
        width: 70%;
    }
    </style>     
        <div class="">
			<section class="page-content course-sec course-message">
            <div class="container">
                <div class="student-widget message-student-widget">
                    <div class="student-widget-group">
                        <div class="col-md-12">
                            <div class="add-compose">
                                <a href="javascript:;" class="btn btn-primary"><i class="fa-solid fa-plus"></i>
                                    Compose</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="chat-window">

                                <div class="chat-cont-left">
                                    <div class="chat-users-list">
                                        <div class="chat-scroll">
                                            <a href="javascript:void(0);" class="media d-flex">
                                                <div class="media-img-wrap flex-shrink-0">
                                                    <div class="avatar avatar-away">
                                                        <img src="assets/img/user/user1.jpg" alt="User Image"
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
                                            <a href="javascript:void(0);" class="media read-chat active d-flex">
                                                <div class="media-img-wrap flex-shrink-0">
                                                    <div class="avatar avatar-online">
                                                        <img src="assets/img/user/user2.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user3.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user4.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user5.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user6.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user7.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user5.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user1.jpg" alt="User Image"
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
                                                        <img src="assets/img/user/user5.jpg" alt="User Image"
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
                                        </div>
                                    </div>
                                </div>


                                <div class="chat-cont-right">
                                    <div class="chat-header">
                                        <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                            <i class="material-icons">chevron_left</i>
                                        </a>
                                        <div class="media d-flex">
                                            <div class="media-img-wrap flex-shrink-0">
                                                <div class="avatar avatar-online">
                                                    <img src="assets/img/user/user2.jpg" alt="User Image"
                                                        class="avatar-img rounded-circle">
                                                </div>
                                            </div>
                                            <div class="media-body flex-grow-1">
                                                <div class="user-name">Doris Brown </div>
                                                <div class="user-status">online</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-scroll">
                                            <ul class="list-unstyled">
                                                <li class="media received d-flex">
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div class="msg-bg">
                                                                <p>Hey There!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="media received d-flex">
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div class="msg-bg">
                                                                <p>How are you?</p>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>Today, 8.30pm</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="media sent d-flex">
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div class="msg-bg">
                                                                <p>Hello!</p>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>Today, 8.33pm</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="media sent d-flex">
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div class="msg-bg">
                                                                <p>I am fine and how are you?</p>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>Today, 8.34pm</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="media received d-flex">
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div>
                                                                <p class="msg-bg">I am doing well, Can we meet tomorrow?
                                                                </p>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>Today, 8.36pm</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="media sent d-flex">
                                                    <div class="media-body flex-grow-1">
                                                        <div class="msg-box">
                                                            <div class="msg-bg">
                                                                <p>Yes Sure!</p>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>Today, 8.58pm</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="chat-footer">
                                        <div class="input-group">
                                            <div class="btn-file btn">
                                                <i class="fa fa-paperclip"></i>
                                                <input type="file">
                                            </div>
                                            <input type="text" class="input-msg-send form-control"
                                                placeholder="Type your message here...">
                                            <button type="button" class="btn btn-primary msg-send-btn rounded-pill"><img
                                                    src="assets/img/send-icon.svg" alt=""></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>
@endsection

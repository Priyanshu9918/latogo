{{-- -------------------- Saved Messages -------------------- --}}
@if($get == 'saved')
    <table class="messenger-list-item" data-contact="{{ Auth::user()->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
            <div class="saved-messages avatar av-m">
                <span class="far fa-bookmark"></span>
            </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ Auth::user()->id }}" data-type="user">Saved Messages <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Contact list -------------------- --}}
@if($get == 'users' && !!$lastMessage)
<?php
$lastMessageBody = mb_convert_encoding($lastMessage->body, 'UTF-8', 'UTF-8');
$lastMessageBody = strlen($lastMessageBody) > 30 ? mb_substr($lastMessageBody, 0, 30, 'UTF-8').'..' : $lastMessageBody;
?>
<table class="messenger-list-item" data-contact="{{ $user->id }}">
    <tr data-action="0">
        {{-- Avatar side --}}
        <td style="position: relative">
            @if($user->active_status)
                <span class="activeStatus"></span>
            @endif
            @php
                $user_img = DB::table('users')->where('id',$user->id)->first();
                $teacher_setting = DB::table('teacher_settings')->where('user_id',$user->id)->first();
                $student_detail = DB::table('student_details')->where('user_id',$user->id)->first();
            @endphp
            @if(isset($user_img) && isset($student_detail) && $user_img->user_type == 1)
                <div class="avatar av-m"
                    style="background-image: url('{{asset('uploads/user/avatar/'.$student_detail->avtar)}}');">
                </div>
            @elseif(isset($user_img) && isset($teacher_setting) && $user_img->user_type == 2)
                <div class="avatar av-m"
                style="background-image: url('{{asset('uploads/user/avatar/'.$teacher_setting->avatar)}}');">
                </div>
            @else
                <div class="avatar av-m"
                style="background-image: url('{{ $user->avatar }}');">
                </div>
            @endif
        </td>
        {{-- center side --}}
        <td>
        <p data-id="{{ $user->id }}" data-type="user">
            {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
            <span class="contact-item-time" data-time="{{$lastMessage->created_at}}">{{ $lastMessage->timeAgo }}</span></p>
        <span>
            {{-- Last Message user indicator --}}
            {!!
                $lastMessage->from_id == Auth::user()->id
                ? '<span class="lastMessageIndicator">You :</span>'
                : ''
            !!}
            {{-- Last message body --}}
            @if($lastMessage->attachment == null)
            {!!
                $lastMessageBody
            !!}
            @else
            <span class="fas fa-file"></span> Attachment
            @endif
        </span>
        {{-- New messages counter --}}
            {!! $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : '' !!}
        </td>
    </tr>
</table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if($get == 'search_item')
<table class="messenger-list-item" data-contact="{{ $user->id }}">
    <tr data-action="0">
        {{-- Avatar side --}}
        <td>
        @if(isset($user_img) && $user_img->user_type == 1)
            <div class="avatar av-m"
                style="background-image: url('{{asset('uploads/user/avatar/'.$user_img->avtar)}}');">
            </div>
        @elseif(isset($user_img) && $user_img->user_type == 2)
            <div class="avatar av-m"
            style="background-image: url('{{asset('uploads/user/avatar/'.$user_img->avatar)}}');">
            </div>
        @else
            <div class="avatar av-m"
            style="background-image: url('{{ $user->avatar }}');">
            </div>
        @endif
        <!-- <div class="avatar av-m"
        style="background-image: url('{{ $user->avatar }}');">
        </div> -->
        </td>
        {{-- center side --}}
        <td>
            <p data-id="{{ $user->id }}" data-type="user">
            {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
        </td>

    </tr>
</table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if($get == 'sharedPhoto')
<div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif



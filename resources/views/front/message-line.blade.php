@php
    $class = ($message->from_user == \Auth::user()->id)?'sent':'received';
@endphp
    <li class="media {{ $class }} d-flex" data-message-id="{{ $message->id }}">
        <div class="media-body flex-grow-1">
            <div class="msg-box">
                <div class="msg-bg">
                    <p>{!! $message->content !!}</p>
                </div>
                <ul class="chat-msg-info">
                    <li>
                        <div class="chat-time">
                            <span><time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->fromUser->name }} • {{ $message->created_at->diffForHumans() }}</time></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </li>

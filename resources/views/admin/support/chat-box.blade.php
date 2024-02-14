<div id="chat_box" class="chat_box chat-cont-right" style="display: none">

        <div class="chat-header">
                <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                    <i class="material-icons">chevron_left</i>
                </a>
                <div class="media d-flex">
                    <div class="media-body flex-grow-1">
                        <div class="user-name">Chat with <i class="chat-user"></i> </div>
                    </div>
                </div>
        </div>
        <div class="chat-body">
                <div class="chat-scroll">
                    <ul class="list-unstyled chat-area">

                    </ul>
                </div>
        </div>



    <div class="chat-footer">
        <div class="input-group form-controls">
            {{-- <div class="btn-file btn">
                <i class="fa fa-paperclip"></i>
                <input type="file" id="chat-media">
            </div> --}}
            <textarea type="text" class="input-msg-send form-control chat_input" placeholder="Type your message here..." style="resize: none;"></textarea>
            <button type="button" class="btn btn-primary msg-send-btn rounded-pill btn-chat" type="button" data-to-user="" disabled>
                <img src="{{ asset('assets/img/send-icon.svg') }}" alt="">
            </button>
        </div>
    </div>

    <input type="hidden" id="to_user_id" value="" />
</div>

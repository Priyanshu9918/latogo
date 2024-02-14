$(function () {
    let pusher = new Pusher($("#pusher_app_key").val(), {
         cluster: $("#pusher_cluster").val(),
         encrypted: true
     });
     let channel = pusher.subscribe('chat');
     // on click on any chat btn render the chat box
    $(".chat-toggle").on("click", function (e) {
        e.preventDefault();
        let ele = $(this);
        let user_id = ele.attr("data-id");
        let username = ele.attr("data-user");

        cloneChatBox(user_id, username, function () {
            let chatBox = $("#chat_box_" + user_id);
            if(!chatBox.hasClass("chat-opened")) {
                chatBox.addClass("chat-opened").slideDown("fast");
                loadLatestMessages(chatBox, user_id);
                    // alert(chatBox);
                    chatBox.find(".chat-scroll").animate({ scrollTop: (chatBox.find(".chat-scroll").offset().top + chatBox.find(".chat-scroll")[0].scrollHeight)*4}, 1500, 'swing');
                // chatBox.find(".chat-scroll").animate({scrollTop: chatBox.find(".chat-scroll").offset().top + chatBox.find(".chat-scroll").outerHeight(true)}, 1500, 'swing');
            }
        });
    });
    // on close chat close the chat box but don't remove it from the dom
    $(".close-chat").on("click", function (e) {
        $(this).parents("div.chat-opened").removeClass("chat-opened").slideUp("fast");
    });


    $(".chat_input").on("change keyup", function (e) {
        if($(this).val() != "") {
            $(this).parents(".form-controls").find(".btn-chat").prop("disabled", false);
        } else {
            $(this).parents(".form-controls").find(".btn-chat").prop("disabled", true);
        }
    });
     // on click the btn send the message
    $(".btn-chat").on("click", function (e) {
        send($(this).attr('data-to-user'), $("#chat_box_" + $(this).attr('data-to-user')).find(".chat_input").val());
    });
    // listen for the send event, this event will be triggered on click the send btn
    channel.bind('send', function(data) {
         displayMessage(data.data);
    });

    let lastScrollTop = 0;
    $(".chat-area").on("scroll", function (e) {
        let st = $(this).scrollTop();
        if(st < lastScrollTop) {
            fetchOldMessages($(this).parents(".chat-opened").find("#to_user_id").val(), $(this).find(".msg_container:first-child").attr("data-message-id"));
        }
        lastScrollTop = st;
    });
    // listen for the oldMsgs event, this event will be triggered on scroll top
    channel.bind('oldMsgs', function(data) {
        displayOldMessages(data);
    });

 });
 /**
  * loaderHtml
  *
  * @returns {string}
  */
 function loaderHtml() {
     return '<i class="glyphicon glyphicon-refresh loader"></i>';
 }
 /**
  * getMessageSenderHtml
  *
  * this is the message template for the sender
  *
  * @param message
  * @returns {string}
  */
 function getMessageSenderHtml(message)
 {
    return `<li class="media sent d-flex" data-message-id="${message.id}">
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div class="msg-bg">
                            <p>${message.content}</p>
                        </div>
                        <ul class="chat-msg-info">
                            <li>
                                <div class="chat-time">
                                    <sup><time datetime="${message.dateTimeStr}"> ${message.fromUserName} • ${message.dateHumanReadable} </time></sup>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>`;

     return `
            <div class="row msg_container base_sent" data-message-id="${message.id}">
         <div class="col-md-10 col-xs-10">
             <div class="messages msg_sent text-right">
                 <p>${message.content}</p>
                 <time datetime="${message.dateTimeStr}"> ${message.fromUserName} • ${message.dateHumanReadable} </time>
             </div>
         </div>
         <div class="col-md-2 col-xs-2 avatar">
             <img src="` + base_url +  '/images/user-avatar.png' + `" width="50" height="50" class="img-responsive">
         </div>
     </div>
     `;
 }
 /**
  * getMessageReceiverHtml
  *
  * this is the message template for the receiver
  *
  * @param message
  * @returns {string}
  */
 function getMessageReceiverHtml(message)
 {
    checkMsg();
    return `<li class="media received d-flex" data-message-id="${message.id}">
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div class="msg-bg">
                            <p>${message.content}</p>
                        </div>
                        <ul class="chat-msg-info">
                            <li>
                                <div class="chat-time">
                                    <sup><time datetime="${message.dateTimeStr}"> ${message.fromUserName} • ${message.dateHumanReadable} </time></sup>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>`;
     return `
            <div class="row msg_container base_receive" data-message-id="${message.id}">
            <div class="col-md-2 col-xs-2 avatar">
              <img src="` + base_url +  '/images/user-avatar.png' + `" width="50" height="50" class="img-responsive">
            </div>
         <div class="col-md-10 col-xs-10">
             <div class="messages msg_receive text-left">
                 <p>${message.content}</p>
                 <time datetime="${message.dateTimeStr}"> ${message.fromUserName}  • ${message.dateHumanReadable} </time>
             </div>
         </div>
     </div>
     `;
 }
 /**
  * cloneChatBox
  *
  * this helper function make a copy of the html chat box depending on receiver user
  * then append it to 'chat-overlay' div
  *
  * @param user_id
  * @param username
  * @param callback
  */
 function cloneChatBox(user_id, username, callback)
 {
     if($("#chat_box_" + user_id).length == 0) {
         let cloned = $("#chat_box").clone(true);
         // change cloned box id
         cloned.attr("id", "chat_box_" + user_id);
         cloned.find(".chat-user").text(username);
         cloned.find(".btn-chat").attr("data-to-user", user_id);
         cloned.find("#to_user_id").val(user_id);
        //  $("#chat-overlay").append(cloned);
        $("#chat-overlay").html(cloned);
     }
     callback();
 }
 /**
  * loadLatestMessages
  *
  * this function called on load to fetch the latest messages
  *
  * @param container
  * @param user_id
  */
 function loadLatestMessages(container, user_id)
 {
     let chat_area = container.find(".chat-area");
     chat_area.html("");
     $.ajax({
         url: base_url + "/load-latest-messages",
         data: {user_id: user_id, _token: $("meta[name='csrf-token']").attr("content")},
         method: "GET",
         dataType: "json",
         beforeSend: function () {
             if(chat_area.find(".loader").length  == 0) {
                 chat_area.html(loaderHtml());
             }
         },
         success: function (response) {
             if(response.state == 1) {
                 response.messages.map(function (val, index) {
                     $(val).appendTo(chat_area);
                 });

                 if(response.img)
                 {
                    $('.c-avatar').attr('src',response.img);
                 }
             }
         },
         complete: function () {
             chat_area.find(".loader").remove();
         }
     });
 }

 function send(to_user, message)
 {
     let chat_box = $("#chat_box_" + to_user);
     let chat_area = chat_box.find(".chat-area");
     let chat_scroll = chat_box.find(".chat-scroll");
     $.ajax({
         url: base_url + "/send",
         data: {to_user: to_user, message: message, _token: $("meta[name='csrf-token']").attr("content")},
         method: "POST",
         dataType: "json",
         beforeSend: function () {
             if(chat_area.find(".loader").length  == 0) {
                 chat_area.append(loaderHtml());
             }
         },
         success: function (response) {
         },
         complete: function () {
             chat_area.find(".loader").remove();
             chat_box.find(".btn-chat").prop("disabled", true);
             chat_box.find(".chat_input").val("");
             chat_scroll.animate({scrollTop: (chat_scroll.offset().top + chat_scroll.outerHeight(true))*4}, 1500, 'swing');
         }
     });
 }
 /**
  * This function called by the send event triggered from pusher to display the message
  *
  * @param message
  */
 function displayMessage(message)
 {
    
     let alert_sound = document.getElementById("chat-alert-sound");
     if($("#current_user").val() == message.from_user_id) {
         let messageLine = getMessageSenderHtml(message);
         $("#chat_box_" + message.to_user_id).find(".chat-area").append(messageLine);
     } else if($("#current_user").val() == message.to_user_id) {
        //  alert_sound.play();
         // for the receiver user check if the chat box is already opened otherwise open it
         cloneChatBox(message.from_user_id, message.fromUserName, function () {
             let chatBox = $("#chat_box_" + message.from_user_id);
             if(!chatBox.hasClass("chat-opened")) {
                 chatBox.addClass("chat-opened").slideDown("fast");
                 loadLatestMessages(chatBox, message.from_user_id);
                 chatBox.find(".chat-scroll").animate({scrollTop: (chatBox.find(".chat-scroll").offset().top + chatBox.find(".chat-scroll").outerHeight(true))*4}, 1500, 'swing');
             } else {
                 let messageLine = getMessageReceiverHtml(message);
                 // append the message for the receiver user
                 $("#chat_box_" + message.from_user_id).find(".chat-area").append(messageLine);
                 chatBox.find(".chat-scroll").animate({scrollTop: (chatBox.find(".chat-scroll").offset().top + chatBox.find(".chat-scroll").outerHeight(true))*4}, 1500, 'swing');
             }
         });
     }
}

function fetchOldMessages(to_user, old_message_id)
{
    let chat_box = $("#chat_box_" + to_user);
    let chat_area = chat_box.find(".chat-area");
    $.ajax({
        url: base_url + "/fetch-old-messages",
        data: {to_user: to_user, old_message_id: old_message_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            if(chat_area.find(".loader").length  == 0) {
                chat_area.prepend(loaderHtml());
            }
        },
        success: function (response) {
        },
        complete: function () {
            chat_area.find(".loader").remove();
        }
    });
}
function displayOldMessages(data)
{
    if(data.data.length > 0) {
        data.data.map(function (val, index) {
            $("#chat_box_" + data.to_user).find(".chat-area").prepend(val);
        });
    }
}
function checkMsg(){
    $.ajax({
        url: "/checkMsg",
        success: 
        function(data){
            $('.head-chat-count').html(data); //insert text of test.php into your div
            // $('.head-chat-count').html("{{ DB::table('messages')->where(['to_user'=>Auth::user()->id,'is_read'=>0])->count() }}");
        },	
        complete: function() {
            // Schedule the next request when the current one's complete
            // setInterval(checkMsg, 5000); // The interval set to 5 seconds
        }
    });
    // setInterval(checkMsg, 4000);
};
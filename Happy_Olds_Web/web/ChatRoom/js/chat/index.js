(function ($) {
    "use strict";

    //Utils.helloWold();

    var dataFromView = $('#data_twig').data('twig');

    var config = {
        longPollingInterval: 500,
        lastTimestamp: dataFromView['lastTimestamp'],
        activeConversation: $('.contact.active').data('id'),
        currentUser: dataFromView['currentUser'],
        waiting: false,
    };

    //console.log(dataFromView);

    wdtEmojiBundle.init('.using-emoji');

    var all = _.union(document.getElementsByClassName('sent'),document.getElementsByClassName('replies'));
    for(var i=0;i<all.length;i++) {
        all[i].classList.add("with-emotes");
    }


    var withEmotes = document.getElementsByClassName('with-emotes');
    for (var i = 0; i < withEmotes.length; i++) {
        withEmotes[i].innerHTML = wdtEmojiBundle.render(withEmotes[i].innerHTML);
    }

    var ev = document.createEvent('Event');
    ev.initEvent('input', true, true);
    // ------------------------------------------------------

    $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight }, "fast");

    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
        $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };

        $("#status-options").removeClass("active");
    });

    function newMessage() {
        var message = $(".message-input input").val();
        if($.trim(message) == '') {
            return false;
        }

        $('<li class="sent"><img src="/'+dataFromView['user_image']+'" alt="" /><p>' + wdtEmojiBundle.render(message) + '</p></li>').appendTo($('.messages ul'));
        $('.message-input input').val(null);
        //wdtEmojiBundle.render(withEmotes[i].innerHTML)
        $('.contact.active .preview').html('<span>You: </span>' + message);
        $(".messages").animate({ scrollTop: $(".messages")[0].scrollHeight }, "fast");

        $.post(dataFromView['routes']['chat_room_api_group_messages_send'],{
            texte: message,
            groupe: config.activeConversation
        }, function(data){
            /*
            if(data["status"] == "ok"){
                $('<li class="sent"><img src="/'+dataFromView['user_image']+'" alt="" /><p>' + wdtEmojiBundle.render(message) + '</p></li>').appendTo($('.messages ul'));
                $('.message-input input').val(null);
                //wdtEmojiBundle.render(withEmotes[i].innerHTML)
                $('.contact.active .preview').html('<span>You: </span>' + message);
                $(".messages").animate({ scrollTop: $(document).height() }, "fast");
            }*/
        });

    };

    $('.contact').click(function(ev){
        $('.contact.active').removeClass('active');
        $(this).addClass('active');
        //console.log($(this).data('name'));
        $('#open_conversation').text($(this).data('name'));

        var groupe_id = $(this).data('id');
        //config.waiting = true;
        config.activeConversation = groupe_id;

        //console.log(groupe_id);

        $('.messages ul').empty();
        $('#search_group').val('');
        $("#contact_list > li").show();
        $(".loader").show();

        var url = Utils.setUrlParameter(dataFromView['routes']['chat_room_api_group_messages_all_by_group'], 'groupe', groupe_id);
        //console.log(url);
        $.get(url, function (data) {
            //console.log(data);


            $(".loader").hide();

            for (var i = 0; i < data.messages.length; i++) {
                var m = data.messages[i];
                var message_type = (m.user.id != config.currentUser)? "replies" : "sent";
                $('<li class="'+message_type+'"><img src="/' + m.user.image + '" alt="" /><p>' + wdtEmojiBundle.render(m.texte)
                    + ((m.user.id != config.currentUser)?'<br><small style="font-style: italic;float: right;">' + m.user.nom.toUpperCase() + ' ' + Utils.capitalizeFirstLetter(m.user.prenom) + '</small>':'')+'</p></li>').appendTo($('.messages ul'));
                //wdtEmojiBundle.render(withEmotes[i].innerHTML)
                //$('.contact.active .preview').html(m.texte);
                //$(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, "fast");

            }
            $(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, "fast");

            config.lastTimestamp = data.lastTimestamp;
            //config.waiting = false;
        });
    });

    $('.submit').click(function() {
        newMessage();
    });

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
            newMessage();
            return false;
        }
    });

    $('#search_group').on('keyup',function(e){
        var value = $(this).val();
        $("#contact_list > li").each(function() {
            if ($(this).data('name').search(value) > -1) {
                $(this).show();
            }
            else {
                $(this).hide();
            }
        });
    });


    setInterval(function(){
        if(!config.waiting) {
            //console.log('longPolling: now, lastTimestamp: ' + config.lastTimestamp);
            config.waiting = true;
            var url = Utils.setUrlParameter(dataFromView['routes']['chat_room_api_group_messages_new'], 'timestamp', config.lastTimestamp);
            $.get(url, function (data) {
                //console.log(data);

                for (var i = 0; i < data.messages.length; i++) {
                    var m = data.messages[i];
                    //console.log('user sending: '+m.user.id);
                    //console.log('current user: '+config.currentUser);
                    if (m.user.id != config.currentUser) {

                        if (m.discussion.groupe_id == config.activeConversation) {
                            $('<li class="replies"><img src="/' + m.user.image + '" alt="" /><p>' + wdtEmojiBundle.render(m.texte)
                                + '<br><small style="font-style: italic;float: right;">' + m.user.nom.toUpperCase() + ' ' + Utils.capitalizeFirstLetter(m.user.prenom) + '</small></p></li>').appendTo($('.messages ul'));
                            //wdtEmojiBundle.render(withEmotes[i].innerHTML)
                            $('.contact.active .preview').html(m.texte);
                            //$(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, "fast");
                        }
                        else {
                            $('#preview_' + m.discussion.groupe_id).html(m.texte);
                        }
                    }
                }
                if(data.messages.length > 0) {
                    $(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, "fast");
                }

                config.lastTimestamp = data.lastTimestamp;
                config.waiting = false;
            });
        }
    },config.longPollingInterval);

})(jQuery);
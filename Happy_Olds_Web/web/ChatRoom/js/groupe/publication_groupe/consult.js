(function ($) {
    "use strict";

    //Utils.helloWold();

    var dataFromView = $('#data_twig').data('twig');

    wdtEmojiBundle.init('.using-emoji');

    var withEmotes = document.getElementsByClassName('with-emotes');
    for (var i = 0; i < withEmotes.length; i++) {
        withEmotes[i].innerHTML = wdtEmojiBundle.render(withEmotes[i].innerHTML);
    }

    var ev = document.createEvent('Event');
    ev.initEvent('input', true, true);
    // ------------------------------------------------------

    var classname = document.getElementsByClassName('using-emoji');
    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('input', function () {
            if(this.value.trim() != '') {
                var id_el = $(this).data('id');
                if(id_el) {
                    document.getElementById("box-comment-" + id_el).style.display = 'block';
                    document.getElementById("emoji-preview-" + id_el).innerHTML = wdtEmojiBundle.render(this.value);
                }
                //this.innerHTML = wdtEmojiBundle.render(this.innerHTML);
            }
            else
            {
                var id_el = $(this).data('id');
                if(id_el) {
                    document.getElementById("box-comment-" + id_el).style.display = 'none';
                }
            }

        });
    }

    document.querySelector('.comment-input').addEventListener('keypress', function (e) {

        var key = e.which || e.keyCode;
        if (key === 13) { // 13 is enter
            e.preventDefault();
            $(this).prop('disabled', true);

            var publication_id = $(this).data('id');
            var element = this;
            console.log(dataFromView['routes']['chat_room_api_comment_add']);
            $.post(
                dataFromView['routes']['chat_room_api_comment_add'],
                {'commentaire': this.value, 'publication': publication_id},
                function(res){
                    console.log(res);
                    if(res && res['status'] == 'ok')
                    {
                        var div = document.getElementById('box-comment-'+publication_id),
                            clone = div.cloneNode(true); // true means clone all childNodes and all event handlers
                        $(clone).removeAttr('id');
                        $(clone).removeAttr('hidden');
                        $(clone).find('#emoji-preview-'+publication_id).removeAttr('id');

                        var delete_button = $(clone).find('#remove-comment-'+publication_id);
                        delete_button.removeAttr('id');
                        delete_button.show();

                        div.style.display = 'none';
                        element.value = "";

                        document.getElementById('nb-comments-'+publication_id).innerHTML =
                            parseInt(document.getElementById('nb-comments-'+publication_id).innerHTML) + 1;

                        document.getElementById('new-comments-'+publication_id).style.display = "block";
                        document.getElementById('new-comments-'+publication_id).appendChild(clone);
                    }

                    $(element).prop('disabled', false);
                    /*
                    var div = document.getElementById('div_id'),
                        clone = div.cloneNode(true); // true means clone all childNodes and all event handlers
                    clone.id = "some_id";
                    document.body.appendChild(clone);
                    */
            });
        }
    });

    //document.getElementById('fullname').dispatchEvent(ev);

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    };

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

})(jQuery);
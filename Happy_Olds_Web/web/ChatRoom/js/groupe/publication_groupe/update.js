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

    var new_publication = document.getElementById('new-publication');
    new_publication.addEventListener('input',function(){
        document.getElementById('publication-preview').innerHTML = wdtEmojiBundle.render(this.value);
    });

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


})(jQuery);
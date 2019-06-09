(function ($) {
    "use strict";

    //Utils.helloWold();

    var dataFromView = $('#data_twig').data('twig');

    $('.asc').append(' <i class="fa fa-sort-up pull-right"></i>');
    $('.desc').append(' <i class="fa fa-sort-down pull-right"></i>');
    $('.sortable').append(' <i class="fa fa-sort pull-right"></i>');

    $(document).on('click', '.sujet_update_btn', function () {
        $('#sujet_modal_id').val($(this).data('id'));
        $('#sujet_modal_label').val($(this).data('label'));
        // it is unnecessary to have to manually call the modal.
        // $('#addBookDialog').modal('show');
    });

})(jQuery);
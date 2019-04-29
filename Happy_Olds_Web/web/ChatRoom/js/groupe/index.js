(function ($) {
    "use strict";

    Utils.helloWold();

    var dataFromView = $('#data_twig').data('twig');
    console.log(dataFromView);

    /*
    $.get("/chat/api/groups",function(data){
        //console.log(data);
        for(var i=0;i<data.length;i++){
            var group = data[i];
            $('#group_list').append("<tr>\n" +
                "            <td hidden=\"true\">"+group.id+"</td>\n" +
                "            <td>"+i+".</td>\n" +
                "            <td>"+group.titre+"</td>\n" +
                "            <td>"+group.description+"</td>\n" +
                "            <td>"+group.type+"</td>\n" +
                "            <td>"+group.members+"</td>\n" +
                "            <td>"+group.creator+"</td>\n" +
                "            <td><a href=\""+Utils.setUrlParameter(dataFromView['routes']['chat_room_group_consult'],'id',group.id)+"\">Consulter</a></td>\n" +
                "        </tr>" +
                "");
        }
    });
    */

})(jQuery);
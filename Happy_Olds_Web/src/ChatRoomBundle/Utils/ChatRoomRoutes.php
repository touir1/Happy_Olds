<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 23/05/2019
 * Time: 18:51
 */

namespace ChatRoomBundle\Utils;


abstract class ChatRoomRoutes
{

    public static function getArrayAll()
    {
        return array_merge(self::getApiArray(),self::getViewsArray());
    }

    public static function getApiArray()
    {
        return [
            self::chat_room_api_comment_add,
            self::chat_room_api_group_add,
            self::chat_room_api_group_consult,
            self::chat_room_api_group_delete,
            self::chat_room_api_group_join,
            self::chat_room_api_group_leave,
            self::chat_room_api_group_list,
            self::chat_room_api_group_my_list,
            self::chat_room_api_group_subscribed_list,
            self::chat_room_api_group_update,
            self::chat_room_api_member_accept,
            self::chat_room_api_member_bann,
            self::chat_room_api_member_decline,
            self::chat_room_api_member_delete,
            self::chat_room_api_member_invite,
            self::chat_room_api_member_list_bann,
            self::chat_room_api_member_list_invite,
            self::chat_room_api_member_list_members,
            self::chat_room_api_member_list_request,
            self::chat_room_api_member_remove_bann,
            self::chat_room_api_publication_add,
            self::chat_room_api_publication_delete,
            self::chat_room_api_publication_consult,
        ];
    }

    public static function getViewsArray()
    {
        return [
            self::chat_room_chat_homepage,
            self::chat_room_group_add,
            self::chat_room_group_consult,
            self::chat_room_group_delete,
            self::chat_room_group_join,
            self::chat_room_group_leave,
            self::chat_room_group_list,
            self::chat_room_group_my_list,
            self::chat_room_group_subscribed_list,
            self::chat_room_group_update,
            self::chat_room_member_accept,
            self::chat_room_member_bann,
            self::chat_room_member_decline,
            self::chat_room_member_delete,
            self::chat_room_member_invite,
            self::chat_room_member_list_bann,
            self::chat_room_member_list_invite,
            self::chat_room_member_list_members,
            self::chat_room_member_list_request,
            self::chat_room_member_remove_bann,
            self::chat_room_publication_add,
            self::chat_room_publication_delete,
            self::chat_room_publication_consult,
        ];
    }

    /** API **/
    // comments
    const chat_room_api_comment_add = 'chat_room_api_comment_add';
    // groups
    const chat_room_api_group_list = 'chat_room_api_group_list';
    const chat_room_api_group_my_list = 'chat_room_api_group_my_list';
    const chat_room_api_group_subscribed_list = 'chat_room_api_group_subscribed_list';
    const chat_room_api_group_consult = 'chat_room_api_group_consult';
    const chat_room_api_group_add = 'chat_room_api_group_add';
    const chat_room_api_group_update = 'chat_room_api_group_update';
    const chat_room_api_group_delete = 'chat_room_api_group_delete';
    const chat_room_api_group_join = 'chat_room_api_group_join';
    const chat_room_api_group_leave = 'chat_room_api_group_leave';
    // members
    const chat_room_api_member_list_invite = 'chat_room_api_member_list_invite';
    const chat_room_api_member_list_members = 'chat_room_api_member_list_members';
    const chat_room_api_member_list_request = 'chat_room_api_member_list_request';
    const chat_room_api_member_list_bann = 'chat_room_api_member_list_bann';
    const chat_room_api_member_invite = 'chat_room_api_member_invite';
    const chat_room_api_member_delete = 'chat_room_api_member_delete';
    const chat_room_api_member_bann = 'chat_room_api_member_bann';
    const chat_room_api_member_remove_bann = 'chat_room_api_member_remove_bann';
    const chat_room_api_member_accept = 'chat_room_api_member_accept';
    const chat_room_api_member_decline = 'chat_room_api_member_decline';
    // publications
    const chat_room_api_publication_add = 'chat_room_api_publication_add';
    const chat_room_api_publication_delete = 'chat_room_api_publication_delete';
    const chat_room_api_publication_consult = 'chat_room_api_publication_consult';

    /** VIEWS **/
    const chat_room_chat_homepage = 'chat_room_chat_homepage';
    // groups
    const chat_room_group_list = 'chat_room_group_list';
    const chat_room_group_my_list = 'chat_room_group_my_list';
    const chat_room_group_subscribed_list = 'chat_room_group_subscribed_list';
    const chat_room_group_consult = 'chat_room_group_consult';
    const chat_room_group_add = 'chat_room_group_add';
    const chat_room_group_update = 'chat_room_group_update';
    const chat_room_group_delete = 'chat_room_group_delete';
    const chat_room_group_join = 'chat_room_group_join';
    const chat_room_group_leave = 'chat_room_group_leave';
    // members
    const chat_room_member_list_invite = 'chat_room_member_list_invite';
    const chat_room_member_list_members = 'chat_room_member_list_members';
    const chat_room_member_list_request = 'chat_room_member_list_request';
    const chat_room_member_list_bann = 'chat_room_member_list_bann';
    const chat_room_member_invite = 'chat_room_member_invite';
    const chat_room_member_delete = 'chat_room_member_delete';
    const chat_room_member_bann = 'chat_room_member_bann';
    const chat_room_member_remove_bann = 'chat_room_member_remove_bann';
    const chat_room_member_accept = 'chat_room_member_accept';
    const chat_room_member_decline = 'chat_room_member_decline';
    // publications
    const chat_room_publication_add = 'chat_room_publication_add';
    const chat_room_publication_delete = 'chat_room_publication_delete';
    const chat_room_publication_consult = 'chat_room_publication_consult';


}
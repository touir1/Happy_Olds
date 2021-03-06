<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 29/04/2019
 * Time: 12:40
 */

namespace ChatRoomBundle\Utils;


abstract class GroupeTypes
{
    const PrivateGroup = "private";
    const PublicGroup = "public";
    const ClosedGroup = "closed";

    public static function getArray()
    {
        return [
            GroupeTypes::PrivateGroup,
            GroupeTypes::PublicGroup,
            GroupeTypes::ClosedGroup
        ];
    }

    public static function getNamedArray()
    {
        return [
            'Privé' => GroupeTypes::PrivateGroup,
            'Publique' => GroupeTypes::PublicGroup,
            'Fermé' => GroupeTypes::ClosedGroup,
        ];
    }

    public static function getDefault()
    {
        return GroupeTypes::ClosedGroup;
    }
}
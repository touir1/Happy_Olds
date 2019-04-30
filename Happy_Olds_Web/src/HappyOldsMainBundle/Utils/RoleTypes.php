<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 29/04/2019
 * Time: 22:59
 */

namespace HappyOldsMainBundle\Utils;


abstract class RoleTypes
{
    const Jeune = "ROLE_JEUNE";
    const Age = "ROLE_AGE";

    public static function getArray()
    {
        return [
            RoleTypes::Age,
            RoleTypes::Jeune,
        ];
    }
}
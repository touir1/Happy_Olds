<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 29/04/2019
 * Time: 22:54
 */

namespace HappyOldsMainBundle\Utils;


abstract class JobTypes
{
    const Medecin = "medecin";
    const Ingenieur = "ingenieur";
    const Autre = "autre";

    public static function getArray()
    {
        return [
            JobTypes::Autre,
            JobTypes::Ingenieur,
            JobTypes::Medecin,
        ];
    }
}
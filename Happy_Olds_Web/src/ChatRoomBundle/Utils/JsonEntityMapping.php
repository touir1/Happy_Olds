<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 17/06/2019
 * Time: 00:37
 */

namespace ChatRoomBundle\Utils;


use ChatRoomBundle\Entity\MembreGroupe;
use ChatRoomBundle\Entity\Message;
use ChatRoomBundle\Entity\PublicationGroupe;
use ChatRoomBundle\Entity\PublicationPieceJointe;
use HappyOldsMainBundle\Entity\User;

class JsonEntityMapping
{
    public static function User(User $user){
        return [
            'id'=>$user->getID(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'date_naissance' => $user->getDateNaissance(),
            'scorefinal' => $user->getScorefinal(),
            'job' => $user->getJob(),
            'ville' => $user->getVille(),
            'path' => $user->getPath(),
            'fullName' => $user->getFile(),
            'webPath' => $user->getWebPath(),
        ];
    }

    public static function Publication(PublicationGroupe $publication){
        return [
            'id' => $publication->getId(),
            'description' => $publication->getDescription(),
            'datePublication' => $publication->getDatePublication(),
        ];
    }

    public static function PieceJointe(PublicationPieceJointe $pieceJointe){
        return [
            "id" => $pieceJointe->getId(),
            "realName" => $pieceJointe->getRealName(),
            "webPath" => $pieceJointe->getWebPath(),
            "mimeType" => $pieceJointe->getMimeType(),
            "path" => $pieceJointe->getPath(),
            "name" => $pieceJointe->getName(),
            "size" => $pieceJointe->getSize(),
        ];
    }

    public static function Message(Message $message){
        return [
            "id" => $message->getId(),
            "createdAt" => $message->getCreatedAt(),
            "texte" => $message->getTexte(),
        ];
    }

    public static function Membre(MembreGroupe $membre){
        return [
            "id" => $membre->getId(),
            "authorized" => $membre->getAuthorized(),
            "banned" => $membre->getBanned(),
        ];
    }
}
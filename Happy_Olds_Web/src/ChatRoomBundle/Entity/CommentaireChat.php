<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Commentaire;

/**
 * CommentaireChat
 *
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\CommentaireChatRepository")
 */
class CommentaireChat extends Commentaire
{

}


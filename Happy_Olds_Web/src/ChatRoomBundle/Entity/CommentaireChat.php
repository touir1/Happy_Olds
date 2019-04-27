<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Commentaire;

/**
 * CommentaireChat
 *
 * @ORM\Table(name="commentaire_chat")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\CommentaireChatRepository")
 */
class CommentaireChat extends Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


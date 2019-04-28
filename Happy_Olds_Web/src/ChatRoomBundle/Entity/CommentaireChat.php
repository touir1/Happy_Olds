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

    /**
     * @ORM\ManyToOne(targetEntity="PublicationGroupe")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id")
     */
    private $publication;

    /**
     * Set publication
     *
     * @param \ChatRoomBundle\Entity\PublicationGroupe $publication
     *
     * @return CommentaireChat
     */
    public function setPublication(\ChatRoomBundle\Entity\PublicationGroupe $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \ChatRoomBundle\Entity\PublicationGroupe
     */
    public function getPublication()
    {
        return $this->publication;
    }
}

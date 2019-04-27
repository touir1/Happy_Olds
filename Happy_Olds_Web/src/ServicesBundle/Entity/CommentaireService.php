<?php

namespace ServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Commentaire;

/**
 * CommentaireService
 *
 * @ORM\Table(name="commentaire_service")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\CommentaireServiceRepository")
 */
class CommentaireService extends Commentaire
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


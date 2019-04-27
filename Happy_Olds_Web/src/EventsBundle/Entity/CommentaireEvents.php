<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Commentaire;

/**
 * CommentaireEvents
 *
 * @ORM\Table(name="commentaire_events")
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\CommentaireEventsRepository")
 */
class CommentaireEvents extends Commentaire
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


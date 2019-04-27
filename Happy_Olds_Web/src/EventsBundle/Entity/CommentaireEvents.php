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
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $id_event;

    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $id_user;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idEvent
     *
     * @param \EventsBundle\Entity\Event $idEvent
     *
     * @return CommentaireEvents
     */
    public function setIdEvent(\EventsBundle\Entity\Event $idEvent = null)
    {
        $this->id_event = $idEvent;

        return $this;
    }

    /**
     * Get idEvent
     *
     * @return \EventsBundle\Entity\Event
     */
    public function getIdEvent()
    {
        return $this->id_event;
    }

    /**
     * Set idUser
     *
     * @param \EventsBundle\Entity\User $idUser
     *
     * @return CommentaireEvents
     */
    public function setIdUser(\EventsBundle\Entity\User $idUser = null)
    {
        $this->id_user = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \EventsBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->id_user;
    }
}

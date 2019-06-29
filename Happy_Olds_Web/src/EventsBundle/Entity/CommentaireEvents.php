<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaireEvents
 *
 * @ORM\Table(name="commentaire_events")
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\CommentaireEventsRepository")
 */
class CommentaireEvents extends \HappyOldsMainBundle\Entity\Commentaire
{
    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent( \EventsBundle\Entity\Event $event = null)
    {
        $this->event = $event;
    }
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
     * @ORM\JoinColumn(name="event_id",referencedColumnName="id")
     */

    private $event;

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


<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;

/**
 * NotificationEvents
 *
 * @ORM\Table(name="notification_events")
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\NotificationEventsRepository")
 */
class NotificationEvents extends Notification
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


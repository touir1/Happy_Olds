<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;

/**
 * NotificationChat
 *
 * @ORM\Table(name="notification_chat")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\NotificationChatRepository")
 */
class NotificationChat extends Notification
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


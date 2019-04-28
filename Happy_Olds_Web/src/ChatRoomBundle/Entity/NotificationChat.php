<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;

/**
 * NotificationChat
 *
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\NotificationChatRepository")
 */
class NotificationChat extends Notification
{

}


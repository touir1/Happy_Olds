<?php

namespace ServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;

/**
 * NotificationService
 *
 * @ORM\Table(name="notification_service")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\NotificationServiceRepository")
 */
class NotificationService extends Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    private $typeNotif;

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
     * @return mixed
     */
    public function getTypeNotif()
    {
        return $this->typeNotif;
    }

    /**
     * @param mixed $typeNotif
     */
    public function setTypeNotif($typeNotif)
    {
        $this->typeNotif = $typeNotif;
    }


}

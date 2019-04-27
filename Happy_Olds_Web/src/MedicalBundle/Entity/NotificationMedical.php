<?php

namespace MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;

/**
 * NotificationMedical
 *
 * @ORM\Table(name="notification_medical")
 * @ORM\Entity(repositoryClass="MedicalBundle\Repository\NotificationMedicalRepository")
 */
class NotificationMedical extends Notification
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


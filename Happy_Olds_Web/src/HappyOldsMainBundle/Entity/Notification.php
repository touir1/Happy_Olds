<?php

namespace HappyOldsMainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;


/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_notif", type="string")
 * @ORM\DiscriminatorMap({"notificationservice" = "\ServicesBundle\Entity\NotificationService",
 *     "notificationevents" = "\EventsBundle\Entity\NotificationEvents",
 *     "notificationmedical" = "\MedicalBundle\Entity\NotificationMedical",
 *     "notificationchat" = "\ChatRoomBundle\Entity\NotificationChat"})
 * @ORM\Entity(repositoryClass="HappyOldsMainBundle\Repository\NotificationRepository")
 */
abstract class Notification extends BaseNotification implements \JsonSerializable
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

    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return get_object_vars($this);
    }

}


<?php

namespace ServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postuler
 *
 * @ORM\Table(name="postuler")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\PostulerRepository")
 */
class Postuler
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

    /**
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="service_id",referencedColumnName="id")
     */

    private $service;
    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */

    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\Notification")
     * @ORM\JoinColumn(name="notif_id",referencedColumnName="id")
     */

    private $notif_id;


    /**
     * Get notif_id
     *
     * @return \HappyOldsMainBundle\Entity\Notification
     */
    public function getNotif_id()
    {
        return $this->notif_id;
    }

    /**
     * Set notif_id
     *
     * @param \HappyOldsMainBundle\Entity\Notification $notif
     *
     * @return Postuler
     */
    public function setNotif_id(\HappyOldsMainBundle\Entity\Notification $notif  = null)
    {
        $this->notif_id = $notif;
    }

    /**
     * Set service
     *
     * @param \ServicesBundle\Entity\Service $service
     *
     * @return Postuler
     */
    public function setService(\ServicesBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \ServicesBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }
}


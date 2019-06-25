<?php

namespace ServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Postuler
 *
 * @ORM\Table(name="postuler")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\PostulerRepository")
 */
class Postuler implements NotifiableInterface
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
     * @ORM\ManyToOne(targetEntity="Service",inversedBy="postuler")
     * @ORM\JoinColumn(name="service_id",referencedColumnName="id")
     */

    private $service;
    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */

    private $user;

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

    /**
     * Set user
     *
     * @param \HappyOldsMainBundle\Entity\User $user
     *
     * @return Postuler
     */
    public function setUser(\HappyOldsMainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HappyOldsMainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnCreate() method.
        $notification=New Notification();
        $notification->setTitle(  $this->getUser()->getUsername()." a postuler a votre service ")
            ->setRoute('services_condidat')
            ->setDescription("#")
            ->setIdUser($this->getService()->getUser()->getId())

            ->setParameters(array('id'=>$this->getService()->getId(),'fromNotif'=>'true','v'=>rand()));
        $builder->addNotification($notification);

        return $builder ;

    }
    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnUpdate() method.


        return $builder ;
    }
    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnDelete() method.
        return $builder;
    }
}

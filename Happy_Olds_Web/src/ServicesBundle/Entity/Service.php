<?php

namespace ServicesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Notification;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;


/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\ServiceRepository")
 */
class Service implements NotifiableInterface
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="valider", type="string", length=255 ,nullable=true)
     */
    private $valider;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */

    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_associe",referencedColumnName="id")
     */

    private $userAssocie;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Postuler", mappedBy="service",cascade={"persist","remove"})
     */
     private $postuler;
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="CommentaireService", mappedBy="service",cascade={"persist","remove"})
     */
    private $commentaires;
    public function __construct() {
        $this->postuler = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    /**
     * Set user
     *
     * @param \HappyOldsMainBundle\Entity\User $user
     *
     * @return Service
     */
    public function setUser(\HappyOldsMainBundle\Entity\User $user = null)
    {
        $this->user = $user;
    }


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
     * Set description
     *
     * @param string $description
     *
     * @return Service
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Service
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Service
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Add postuler
     *
     * @param \ServicesBundle\Entity\Postuler $postuler
     *
     * @return Service
     */
    public function addPostuler(\ServicesBundle\Entity\Postuler $postuler)
    {
        $this->postuler[] = $postuler;

        return $this;
    }

    /**
     * Remove postuler
     *
     * @param \ServicesBundle\Entity\Postuler $postuler
     */
    public function removePostuler(\ServicesBundle\Entity\Postuler $postuler)
    {
        $this->postuler->removeElement($postuler);
    }

    /**
     * Get postuler
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostuler()
    {
        return $this->postuler;
    }

    /**
     * Set userAssocie
     *
     * @param \HappyOldsMainBundle\Entity\User $userAssocie
     *
     * @return Service
     */
    public function setUserAssocie(\HappyOldsMainBundle\Entity\User $userAssocie = null)
    {
        $this->userAssocie = $userAssocie;

        return $this;
    }

    /**
     * Get userAssocie
     *
     * @return \HappyOldsMainBundle\Entity\User
     */
    public function getUserAssocie()
    {
        return $this->userAssocie;
    }

    /**
     * Set valider
     *
     * @param string $valider
     *
     * @return Service
     */
    public function setValider($valider)
    {
        $this->valider = $valider;

        return $this;
    }

    /**
     * Get valider
     *
     * @return string
     */
    public function getValider()
    {
        return $this->valider;
    }

    /**
     * Add commentaire
     *
     * @param \ServicesBundle\Entity\CommentaireService $commentaire
     *
     * @return Service
     */
    public function addCommentaire(\ServicesBundle\Entity\CommentaireService $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \ServicesBundle\Entity\CommentaireService $commentaire
     */
    public function removeCommentaire(\ServicesBundle\Entity\CommentaireService $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
    function jsonSerialize()
    {
        return [
            "iduser"        => $this->getUser()->getId(),
            //"userassocier"    => $this->getUserAssocie()->getId(),
        ];
    }

    /**
     * Build notifications on entity creation
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnCreate() method.
        return $builder ;
    }

    /**
     * Build notifications on entity update
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnUpdate() method.
        if($this->getUserAssocie()!=null){
            $notification=New Notification();
            $notification->setTitle(  $this->getUser()->getUsername()." a accepter  votre condidature ")
                ->setRoute('services_publier')
                ->setDescription("#")
                ->setIdUser($this->getUserAssocie()->getId())

                ->setParameters(array('id'=>$this->getUserAssocie()->getId(),'fromNotif'=>'true','v'=>rand()));
            $builder->addNotification($notification);

            return $builder ;
        }
        return $builder ;
    }

    /**
     * Build notifications on entity delete
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnDelete() method.
        return $builder ;
    }
}

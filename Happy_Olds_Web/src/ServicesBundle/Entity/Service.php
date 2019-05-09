<?php

namespace ServicesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\ServiceRepository")
 */
class Service
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
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Postuler", mappedBy="service")
     */
     private $postuler;
    public function __construct() {
        $this->postuler = new ArrayCollection();
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
}

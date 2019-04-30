<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PublicationGroupe
 *
 * @ORM\Table(name="publication_groupe")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="publication_type", type="string")
 * @ORM\DiscriminatorMap({"publicationGroupe" = "PublicationGroupe", "live" = "Live"})
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\PublicationGroupeRepository")
 */
class PublicationGroupe
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="pieceJointe", type="string", length=255)
     */
    private $pieceJointe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="publications")
     * @ORM\JoinColumn(name="groupe_id", referencedColumnName="id")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return PublicationGroupe
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PublicationGroupe
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
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return PublicationGroupe
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return PublicationGroupe
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set groupe
     *
     * @param \ChatRoomBundle\Entity\Groupe $groupe
     *
     * @return PublicationGroupe
     */
    public function setGroupe(\ChatRoomBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \ChatRoomBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set user
     *
     * @param \HappyOldsMainBundle\Entity\User $user
     *
     * @return PublicationGroupe
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
}

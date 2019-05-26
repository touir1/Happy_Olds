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
 *
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @ORM\OneToOne(targetEntity="PublicationPieceJointe", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="publication_piece_jointe_id", referencedColumnName="id", nullable=true)
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
     * @ORM\OneToMany(targetEntity="CommentaireChat", mappedBy="publication", cascade={"persist","remove"})
     */
    private $commentaires;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add commentaire
     *
     * @param \ChatRoomBundle\Entity\CommentaireChat $commentaire
     *
     * @return PublicationGroupe
     */
    public function addCommentaire(\ChatRoomBundle\Entity\CommentaireChat $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \ChatRoomBundle\Entity\CommentaireChat $commentaire
     */
    public function removeCommentaire(\ChatRoomBundle\Entity\CommentaireChat $commentaire)
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


    /**
     * Set pieceJointe
     *
     * @param \ChatRoomBundle\Entity\PublicationPieceJointe $pieceJointe
     *
     * @return PublicationGroupe
     */
    public function setPieceJointe(\ChatRoomBundle\Entity\PublicationPieceJointe $pieceJointe = null)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return \ChatRoomBundle\Entity\PublicationPieceJointe
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }
}

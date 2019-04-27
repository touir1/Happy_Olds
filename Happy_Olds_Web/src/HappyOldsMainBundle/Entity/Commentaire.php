<?php

namespace HappyOldsMainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\DiscriminatorColumn(name="type_commentaire", type="string")
 * @ORM\DiscriminatorMap({"commentaireservice" = "\ServicesBundle\Entity\CommentaireService",
 *                        "commentaireevents" = "\EventsBundle\Entity\CommentaireEvents",
 *                        "commentairechat" = "\ChatRoomBundle\Entity\CommentaireChat",
 *                        "commentairemedical" = "\MedicalBundle\Entity\CommentaireMedical"})
 * @ORM\Entity(repositoryClass="HappyOldsMainBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;


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
     * Set texte
     *
     * @param string $texte
     *
     * @return Commentaire
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }
}


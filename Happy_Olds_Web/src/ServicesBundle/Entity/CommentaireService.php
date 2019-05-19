<?php

namespace ServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HappyOldsMainBundle\Entity\Commentaire;

/**
 * CommentaireService
 *
 * @ORM\Table(name="commentaire_service")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\CommentaireServiceRepository")
 */
class CommentaireService extends Commentaire
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
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="service_id",referencedColumnName="id")
     */

    private $service;


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
     * Set service
     *
     * @param \ServicesBundle\Entity\Service $service
     *
     * @return CommentaireService
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

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
}


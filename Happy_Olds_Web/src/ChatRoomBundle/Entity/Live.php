<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Live
 *
 * @ORM\Table(name="live")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\LiveRepository")
 */
class Live
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
     * @var bool
     *
     * @ORM\Column(name="fin", type="boolean")
     */
    private $fin;


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
     * Set fin
     *
     * @param boolean $fin
     *
     * @return Live
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return bool
     */
    public function getFin()
    {
        return $this->fin;
    }
}


<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Live
 *
 * @ORM\Table(name="live")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\LiveRepository")
 */
class Live extends  PublicationGroupe
{

    /**
     * @var bool
     *
     * @ORM\Column(name="fin", type="boolean")
     */
    private $fin;

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

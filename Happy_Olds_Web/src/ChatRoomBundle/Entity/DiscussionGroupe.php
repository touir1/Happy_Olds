<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiscussionGroupe
 *
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\DiscussionGroupeRepository")
 */
class DiscussionGroupe extends Discussion
{
    /**
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumn(name="groupe_id", referencedColumnName="id")
     */
    private $groupe;

    /**
     * Set groupe
     *
     * @param \ChatRoomBundle\Entity\Groupe $groupe
     *
     * @return DiscussionGroupe
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
}

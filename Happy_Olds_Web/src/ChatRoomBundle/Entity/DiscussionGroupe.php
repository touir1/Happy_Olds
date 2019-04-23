<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiscussionGroupe
 *
 * @ORM\Table(name="discussion_groupe")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\DiscussionGroupeRepository")
 */
class DiscussionGroupe
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


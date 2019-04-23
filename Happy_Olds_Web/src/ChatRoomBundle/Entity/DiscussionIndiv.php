<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiscussionIndiv
 *
 * @ORM\Table(name="discussion_indiv")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\DiscussionIndivRepository")
 */
class DiscussionIndiv
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


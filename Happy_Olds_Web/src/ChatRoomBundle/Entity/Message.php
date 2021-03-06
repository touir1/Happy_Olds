<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\MessageRepository")
 */
class Message
{

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
    }

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
     * @ORM\ManyToOne(targetEntity="DiscussionGroupe", inversedBy="messages")
     * @ORM\JoinColumn(name="discussion_id", referencedColumnName="id")
     */
    private $discussion;

    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }


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
     * @return Message
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

    /**
     * Set discussion
     *
     * @param \ChatRoomBundle\Entity\DiscussionGroupe $discussion
     *
     * @return Message
     */
    public function setDiscussion(\ChatRoomBundle\Entity\DiscussionGroupe $discussion = null)
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * Get discussion
     *
     * @return \ChatRoomBundle\Entity\DiscussionGroupe
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * Set user
     *
     * @param \HappyOldsMainBundle\Entity\User $user
     *
     * @return Message
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

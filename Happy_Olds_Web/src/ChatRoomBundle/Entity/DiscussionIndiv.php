<?php

namespace ChatRoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiscussionIndiv
 *
 * @ORM\Entity(repositoryClass="ChatRoomBundle\Repository\DiscussionIndivRepository")
 */
class DiscussionIndiv extends Discussion
{

    /**
     * @ORM\OneToMany(targetEntity="\HappyOldsMainBundle\Entity\User", mappedBy="discussionIndiv")
     */
    private $participants;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add participant
     *
     * @param \HappyOldsMainBundle\Entity\User $participant
     *
     * @return DiscussionIndiv
     */
    public function addParticipant(\HappyOldsMainBundle\Entity\User $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param \HappyOldsMainBundle\Entity\User $participant
     */
    public function removeParticipant(\HappyOldsMainBundle\Entity\User $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}

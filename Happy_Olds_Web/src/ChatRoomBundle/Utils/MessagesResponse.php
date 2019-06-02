<?php
/**
 * Created by PhpStorm.
 * User: touir
 * Date: 29/05/2019
 * Time: 17:41
 */

namespace ChatRoomBundle\Utils;


class MessagesResponse
{

    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $messages;

    /**
     * @var \DateTime
     */
    private $lastTimestamp;

    /**
    * Get messages
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set messages
     *
     * @param \Doctrine\Common\Collections\Collection $messages
     *
     * @return MessagesResponse
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * Add message
     *
     * @param \ChatRoomBundle\Entity\Message $message
     *
     * @return MessagesResponse
     */
    public function addMessage(\ChatRoomBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Set lastTimestamp
     *
     * @param \DateTime $lastTimestamp
     *
     * @return MessagesResponse
     */
    public function setLastTimestamp($lastTimestamp)
    {
        $this->lastTimestamp = $lastTimestamp;

        return $this;
    }

    /**
     * Get lastTimestamp
     *
     * @return \DateTime
     */
    public function getLastTimestamp()
    {
        return $this->lastTimestamp;
    }
}
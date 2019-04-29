<?php

namespace ServicesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="ServicesBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;


    /**
     * @ORM\OneToOne(targetEntity=Service::class,cascade={"remove"})
     * @ORM\JoinColumn(name="service_id",referencedColumnName="id")
     */
    private $service;
    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */

    private $user;


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
     * Set user
     *
     * @param \HappyOldsMainBundle\Entity\User $user
     *
     * @return Evaluation
     */
    public function setUser(\HappyOldsMainBundle\Entity\Service $user = null)
    {
        $this->user = $user;
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

    /**
     * Set service
     *
     * @param \ServicesBundle\Entity\Service $service
     *
     * @return Postuler
     */
    public function setService(\ServicesBundle\Entity\Service $service = null)
    {
        $this->service = $service;
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
     * Set score
     *
     * @param integer $score
     *
     * @return Evaluation
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
}


<?php

namespace MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="MedicalBundle\Repository\ReponseRepository")
 */
class Reponse implements NotifiableInterface
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
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="reponses")
     * @ORM\JoinColumn(name="question_id",referencedColumnName="id")
     */
    private $question;
    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */

    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateR", type="date")
     */


    private $dateR;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;


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
     * Set text
     *
     * @param string $text
     *
     * @return Reponse
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set question
     *
     * @param \MedicalBundle\Entity\Question $question
     *
     * @return Reponse
     */
    public function setQuestion(\MedicalBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \MedicalBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param \HappyOldsMainBundle\Entity\User $user
     *
     * @return Reponse
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
     * Set dateR
     *
     * @param \DateTime $dateR
     *
     * @return Reponse
     */
    public function setDateR($dateR)
    {
        $this->dateR = $dateR;

        return $this;
    }

    /**
     * Get dateR
     *
     * @return \DateTime
     */
    public function getDateR()
    {
        return $this->dateR;
    }

    public function __construct()
    {
        $this->dateR = new \DateTime('now');
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnCreate() method.
        $notification=New NotificationMedical();
        $notification->setTitle("Nouvelle reponse")
            ->setDescription($this->getText())
            ->setRoute('medical_detail')
            ->setParameters(array('id'=>$this->getId()));
        $builder->addNotification($notification);

        return $builder ;

    }
    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnUpdate() method.
        $notification=New NotificationMedical();
        $notification->setTitle("mise à jour reponse")
            ->setDescription($this->getText())
            ->setRoute('medical_detail')
            ->setParameters(array('id'=>$this->getId()));
        $builder->addNotification($notification);

        return $builder ;
    }
    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnDelete() method.
        return $builder;
    }
}

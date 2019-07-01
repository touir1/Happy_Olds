<?php

namespace EventsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\EventRepository")
 */
class Event
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @ORM\ManyToOne(targetEntity="\HappyOldsMainBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $id_user;
    /**
     * @var int
     *
     * @ORM\Column(name="nbrParticipant", type="integer")
     */
    private $nbrParticipant;


    /**
     * @var int
     *
     * @ORM\Column(name="nbrDispo", type="integer")
     */
    private $nbrDispo;


    /**
     * @var int
     *
     * @ORM\Column(name="Participant", type="integer")
     */
    private $Participant;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * *@Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Participer", mappedBy="event")
     */
    private $Participants;

    public function __construct() {
        $this->Participants = new ArrayCollection();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Event
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set nbrParticipant
     *
     * @param integer $nbrParticipant
     *
     * @return Event
     */
    public function setNbrParticipant($nbrParticipant)
    {
        $this->nbrParticipant = $nbrParticipant;

        return $this;
    }

    /**
     * Get nbrParticipant
     *
     * @return int
     */
    public function getNbrParticipant()
    {
        return $this->nbrParticipant;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Event
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Event
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }



    /**
     * Set id_user
     *
     * @param \HappyOldsMainBundle\Entity\User $id_user
     *
     * @return Event
     */
    public function setIdUser(\HappyOldsMainBundle\Entity\User $id_user = null )
    {

        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get id_user
     *
     * @return \HappyOldsMainBundle\Entity\User
     */
    public function getIdUser()
    {

        return $this->id_user;
    }


    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to

        $filePath = md5(uniqid($this->getIdUser()."_profil",true)).".".
            $this->getFile()->guessClientExtension();

        $this->getFile()->move(
            $this->getUploadRootDir(),$filePath
        );

        // set the path property to the filename where you've saved the file
        $this->path = $filePath;

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    /**
     * Set path
     *
     * @param string $path
     *
     * @return Event
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Event
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set nbrDispo
     *
     * @param integer $nbrDispo
     *
     * @return Event
     */
    public function setNbrDispo($nbrDispo)
    {
        $this->nbrDispo = $nbrDispo;

        return $this;
    }

    /**
     * Get nbrDispo
     *
     * @return integer
     */
    public function getNbrDispo()
    {
        return $this->nbrDispo;
    }

    /**
     * Set participant
     *
     * @param integer $participant
     *
     * @return Event
     */
    public function setParticipant($participant)
    {
        $this->Participant = $participant;

        return $this;
    }

    /**
     * Get participant
     *
     * @return integer
     */
    public function getParticipant()
    {
        return $this->Participant;
    }

    /**
     * Add participant
     *
     * @param \EventsBundle\Entity\Participer $participant
     *
     * @return Event
     */
    public function addParticipant(\EventsBundle\Entity\Participer $participant)
    {
        $this->Participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param \EventsBundle\Entity\Participer $participant
     */
    public function removeParticipant(\EventsBundle\Entity\Participer $participant)
    {
        $this->Participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->Participants;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Event
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }
}

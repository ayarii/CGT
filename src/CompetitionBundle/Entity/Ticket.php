<?php

namespace CompetitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket", indexes={@ORM\Index(name="idCompetition", columns={"idCompetition"})})
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTicket", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idticket;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="Photo", type="string", length=255, nullable=false)
     */
    private $photo="img";

    /**
     * @return int
     */
    public function getIdticket()
    {
        return $this->idticket;
    }

    /**
     * @param int $idticket
     */
    public function setIdticket($idticket)
    {
        $this->idticket = $idticket;
    }

    /**
     * @return \FosUser
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param \FosUser $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }



    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getMotdepasse()
    {
        return $this->motdepasse;
    }

    /**
     * @param string $motdepasse
     */
    public function setMotdepasse($motdepasse)
    {
        $this->motdepasse = $motdepasse;
    }

    /**
     * @return \DateTime
     */
    public function getDateemission()
    {
        return $this->dateemission;
    }

    /**
     * @param \DateTime $dateemission
     */
    public function setDateemission($dateemission)
    {
        $this->dateemission = $dateemission;
    }

    /**
     * @return \Competition
     */
    public function getIdcompetition()
    {
        return $this->idcompetition;
    }

    /**
     * @param \Competition $idcompetition
     */
    public function setIdcompetition($idcompetition)
    {
        $this->idcompetition = $idcompetition;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="MotDePasse", type="string", length=11, nullable=false)
     */
    private $motdepasse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateEmission", type="datetime", nullable=false)
     */
    private $dateemission;

    /**
     * @var \Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCompetition", referencedColumnName="idCompetition")
     * })
     */
    private $idcompetition;


}


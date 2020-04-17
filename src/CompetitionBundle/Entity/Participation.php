<?php

namespace CompetitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idCompetition", columns={"idCompetition"})})
 * @ORM\Entity(repositoryClass="CompetitionBundle\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @return int
     */
    public function getIdparticipation()
    {
        return $this->idparticipation;
    }

    /**
     * @param int $idparticipation
     */
    public function setIdparticipation($idparticipation)
    {
        $this->idparticipation = $idparticipation;
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
     * @return \User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param \User $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="idParticipation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idparticipation;

    /**
     * @var \Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCompetition", referencedColumnName="idCompetition")
     * })
     */
    private $idcompetition;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;


}


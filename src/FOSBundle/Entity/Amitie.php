<?php

namespace FOSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amitie
 *
 * @ORM\Table(name="amitie", indexes={@ORM\Index(name="amitie_ibfk_1", columns={"idme"}), @ORM\Index(name="amitie_ibfk_2", columns={"iduser"}), @ORM\Index(name="amitie_ibfk_3", columns={"SenderId"})})
 * @ORM\Entity
 */
class Amitie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAmitie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idamitie;

    /**
     * @var integer
     *
     * @ORM\Column(name="Etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="BlockId", type="integer", nullable=false)
     */
    private $blockid;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idme", referencedColumnName="id")
     * })
     */
    private $idme;

    /**
     * @return \FosUser
     */
    public function getIdme()
    {
        return $this->idme;
    }

    /**
     * @param \FosUser $idme
     */
    public function setIdme($idme)
    {
        $this->idme = $idme;
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
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SenderId", referencedColumnName="id")
     * })
     */
    private $senderid;

    /**
     * @return int
     */
    public function getIdamitie()
    {
        return $this->idamitie;
    }

    /**
     * @param int $idamitie
     */
    public function setIdamitie($idamitie)
    {
        $this->idamitie = $idamitie;
    }

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return int
     */
    public function getBlockid()
    {
        return $this->blockid;
    }

    /**
     * @param int $blockid
     */
    public function setBlockid($blockid)
    {
        $this->blockid = $blockid;
    }









    /**
     * @return \FosUser
     */
    public function getSenderid()
    {
        return $this->senderid;
    }

    /**
     * @param \FosUser $senderid
     */
    public function setSenderid($senderid)
    {
        $this->senderid = $senderid;
    }




}


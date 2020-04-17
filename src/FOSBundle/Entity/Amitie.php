<?php

namespace FOSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amitie
 *
 * @ORM\Table(name="amitie", indexes={@ORM\Index(name="amitie_ibfk_1", columns={"idUser1"}), @ORM\Index(name="amitie_ibfk_2", columns={"idUser2"}), @ORM\Index(name="amitie_ibfk_3", columns={"SenderId"})})
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
     *   @ORM\JoinColumn(name="idUser1", referencedColumnName="id")
     * })
     */
    private $iduser1;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser2", referencedColumnName="id")
     * })
     */
    private $iduser2;

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
    public function getIduser1()
    {
        return $this->iduser1;
    }

    /**
     * @param \FosUser $iduser1
     */
    public function setIduser1($iduser1)
    {
        $this->iduser1 = $iduser1;
    }

    /**
     * @return \FosUser
     */
    public function getIduser2()
    {
        return $this->iduser2;
    }

    /**
     * @param \FosUser $iduser2
     */
    public function setIduser2($iduser2)
    {
        $this->iduser2 = $iduser2;
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


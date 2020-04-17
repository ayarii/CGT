<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\ConversationRepository")
 */
class Conversation
{


    public function __toString()
    {
        return $this->Nom;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="idConversation", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idConversation;


    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=false)
     */
    private $Nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="date", nullable=false)
     */
    private $DateCreation;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Me", referencedColumnName="id")
     * })
     */
    private $idMe;


    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idU_Friend", referencedColumnName="id")
     * })
     */
    private $idUFriend;

    /**
     * @return int
     */
    public function getIdConversation()
    {
        return $this->idConversation;
    }

    /**
     * @param int $idConversation
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = $idConversation;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->Nom;
    }

    /**
     * @param string $Nom
     */
    public function setNom($Nom)
    {
        $this->Nom = $Nom;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->DateCreation;
    }

    /**
     * @param \DateTime $DateCreation
     */
    public function setDateCreation($DateCreation)
    {
        $this->DateCreation = $DateCreation;
    }

    /**
     * @return \FosUser
     */
    public function getIdMe()
    {
        return $this->idMe;
    }

    /**
     * @param \FosUser $idMe
     */
    public function setIdMe($idMe)
    {
        $this->idMe = $idMe;
    }

    /**
     * @return \FosUser
     */
    public function getIdUFriend()
    {
        return $this->idUFriend;
    }

    /**
     * @param \FosUser $idUFriend
     */
    public function setIdUFriend($idUFriend)
    {
        $this->idUFriend = $idUFriend;
    }





}


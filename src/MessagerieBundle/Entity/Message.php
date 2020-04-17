<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="idConversation", columns={"id_Conversation"})})
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\MessageRepository")
 */
class Message
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idMessage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMessage;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Sender", referencedColumnName="id")
     * })
     */
    private $idSender;


    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Receiver", referencedColumnName="id")
     * })
     */
    private $idReceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="Contenu", type="string", length=255, nullable=false)
     */
    private $Contenu;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Message", type="datetime", nullable=false)
     */
    private $DateMessage;

    /**
     * Message constructor.
     */


    /**
     * @return \DateTime
     */
    public function getDateMessage()
    {
        return $this->DateMessage;
    }

    /**
     * @param \DateTime $DateMessage
     */
    public function setDateMessage(\DateTime $DateMessage)
    {
        $this->DateMessage = $DateMessage;
    }


    /**
     * @var \Conversation
     *
     * @ORM\ManyToOne(targetEntity="Conversation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Conversation", referencedColumnName="idConversation")
     * })
     */
    private $idConversation;


    /**
     * @return int
     */
    public function getIdMessage()
    {
        return $this->idMessage;
    }

    /**
     * @param int $idMessage
     */
    public function setIdMessage($idMessage)
    {
        $this->idMessage = $idMessage;
    }

    /**
     * @return \FosUser
     */
    public function getIdSender()
    {
        return $this->idSender;
    }

    /**
     * @param \FosUser $idSender
     */
    public function setIdSender($idSender)
    {
        $this->idSender = $idSender;
    }

    /**
     * @return \FosUser
     */
    public function getIdReceiver()
    {
        return $this->idReceiver;
    }

    /**
     * @param \FosUser $idReceiver
     */
    public function setIdReceiver($idReceiver)
    {
        $this->idReceiver = $idReceiver;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->Contenu;
    }

    /**
     * @param string $Contenu
     */
    public function setContenu($Contenu)
    {
        $this->Contenu = $Contenu;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \Conversation
     */
    public function getIdConversation()
    {
        return $this->idConversation;
    }

    /**
     * @param \Conversation $idConversation
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = $idConversation;
    }









}


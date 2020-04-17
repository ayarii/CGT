<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\VoteRepository")
 *  @Notifiable(name="Vote")
 */
class Vote implements NotifiableInterface
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
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $idUser;
    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_post", referencedColumnName="id")
     * })
     */
    private $post;

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return \FosUser
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \FosUser $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="Valeur", type="integer")
     */
    private $valeur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set valeur
     *
     * @param integer $valeur
     *
     * @return Vote
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return int
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Vote
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}


<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\commentaireRepository")
 *  @Notifiable(name="commentaire")
 */
class commentaire implements NotifiableInterface
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
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_post", referencedColumnName="id")
     * })
     */
    private $post;

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
     * @var string
     *
     * @ORM\Column(name="contenue", type="string", length=255)
     */
    private $contenue;




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
     * Set contenue
     *
     * @param string $contenue
     *
     * @return commentaire
     */
    public function setContenue($contenue)
    {
        $this->contenue = $contenue;

        return $this;
    }

    /**
     * Get contenue
     *
     * @return string
     */
    public function getContenue()
    {
        return $this->contenue;
    }



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}
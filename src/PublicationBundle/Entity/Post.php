<?php

namespace PublicationBundle\Entity;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\PostRepository")
 *  @Notifiable(name="Post")
 */
class Post implements NotifiableInterface
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
     * @return \FosUser
     */
    public function getIdauthor()
    {
        return $this->idauthor;
    }

    /**
     * @param \FosUser $idauthor
     */
    public function setIdauthor($idauthor)
    {
        $this->idauthor = $idauthor;
    }
    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $idauthor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */

    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="contenue", type="string" , length=255)
     */
    private $contenue;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Post
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

    /**
     * Set contenue
     *
     * @param string $contenue
     *
     * @return Post
     */
    public function setSrcPublication($contenue)
    {
        $this->contenue = $contenue;

        return $this;
    }

    /**
     * Get contenue
     *
     * @return string
     */
    public function getcontenue()
    {
        return $this->contenue;
    }
    /**
     * @return int
     */
    public function getReactionPost()
    {
        return $this->ReactionPost;
    }

    /**
     * @param int $ReactionPost
     *
     * @return Post
     */
    public function setReactionPost($ReactionPost)
    {
        $this->ReactionPost = $ReactionPost;
        return $this;
    }



    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Post
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="Reacts_on_post", type="integer", options={"default" : 0})
     */
    private $ReactionPost;
    /**
     * @var int
     *
     * @ORM\Column(name="votes_on_post", type="integer", options={"default" : 0})
     */
    private $votesPost;

    /**
     * @return int
     */
    public function getVotesPost()
    {
        return $this->votesPost;
    }

    /**
     * @param int $votesPost
     *
     * @return Post
     */
    public function setVotesPost($votesPost)
    {
        $this->votesPost = $votesPost;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbcomments()
    {
        return $this->nbcomments;
    }

    /**
     * @param int $nbcomments
     */
    public function setNbcomments($nbcomments)
    {
        $this->nbcomments = $nbcomments;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="comments_on_post", type="integer", options={"default" : 0})
     */
    private $nbcomments;
}


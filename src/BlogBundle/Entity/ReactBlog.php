<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * ReactBlog
 *
 * @ORM\Table(name="react_blog")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\ReactBlogRepository")
 */
class ReactBlog implements NotifiableInterface
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
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;


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
     * Set type
     *
     * @param integer $type
     *
     * @return ReactBlog
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idblog", referencedColumnName="id")
     * })
     */
    private $idblog;

    /**
     * @return Article
     */
    public function getIdblog()
    {
        return $this->idblog;
    }

    /**
     * @param Article $idblog
     */
    public function setIdblog($idblog)
    {
        $this->idblog = $idblog;
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
}


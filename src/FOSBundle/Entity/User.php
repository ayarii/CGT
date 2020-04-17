<?php
// src/AppBundle/Entity/User.php

namespace FOSBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert ;
use Mgilet\NotificationBundle\NotifiableInterface;
use Mgilet\NotificationBundle\Annotation\Notifiable;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @Notifiable(name="fos_user")
 */
class User extends BaseUser implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @return string
     */
    public function getTypecompte()
    {
        return $this->typecompte;
    }

    /**
     * @param string $typecompte
     */
    public function setTypecompte($typecompte)
    {
        $this->typecompte = $typecompte;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="typecompte", type="string", length=255)
     */
    private $typecompte;

    /**
     * @var string
     *
     * @ORM\Column(name="typetalent", type="string", length=255)
     */
    private $typetalent="Dance";

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return int
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param int $numtel
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;
    }

    /**
     * @return string
     */
    public function getImguser()
    {
        return $this->imguser;
    }

    /**
     * @param string $imguser
     */
    public function setImguser($imguser)
    {
        $this->imguser = $imguser;
    }

    /**
     * @return int
     */
    public function getNbdiament()
    {
        return $this->nbdiament;
    }

    /**
     * @param int $nbdiament
     */
    public function setNbdiament($nbdiament)
    {
        $this->nbdiament = $nbdiament;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom="prenom";

    /**
     * @var integer
     *
     * @ORM\Column(name="numtel", type="integer")
     */
    private $numtel=23422387;

    /**
     * @var string
     *
     * @ORM\Column(name="imguser", type="string", length=255)
     */
    private $imguser;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbdiament", type="integer")
     */
    private $nbdiament=500;

    /**
     * @return string
     */
    public function getTypetalent()
    {
        return $this->typetalent;
    }

    /**
     * @param string $typetalent
     */
    public function setTypetalent($typetalent)
    {
        $this->typetalent = $typetalent;
    }



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }



    public function getAbsoluteImage()
    {
        return null === $this->imguser
            ? null
            : $this->getUploadRootDir().'/'.$this->imguser;
    }

    public function getWebImage()
    {
        return null === $this->imguser
            ? null
            : $this->getUploadDir().'/'.$this->imguser;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'image';
    }




    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the image property to the filename where you've saved the file
        $this->imguser = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

}
<?php

namespace CompetitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Competition
 *
 * @ORM\Table(name="competition", indexes={@ORM\Index(name="FK_AB55E24F5E5C27E9", columns={"idUser"})})
 * @ORM\Entity(repositoryClass="CompetitionBundle\Repository\CompetitionRepository")
 */
class Competition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCompetition", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcompetition;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeDeTalent", type="string", length=255, nullable=false)
     */
    private $typedetalent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="date", nullable=false)
     */
    private $datefin;

    /**
     * @var integer
     *
     * @ORM\Column(name="Cout", type="integer", nullable=false)
     */
    private $cout;

    /**
     * @var string
     *
     * @ORM\Column(name="imageC", type="string", length=255, nullable=false)
     */
    private $imagec;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @return int
     */
    public function getIdcompetition()
    {
        return $this->idcompetition;
    }

    /**
     * @param int $idcompetition
     */
    public function setIdcompetition($idcompetition)
    {
        $this->idcompetition = $idcompetition;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTypedetalent()
    {
        return $this->typedetalent;
    }

    /**
     * @param string $typedetalent
     */
    public function setTypedetalent($typedetalent)
    {
        $this->typedetalent = $typedetalent;
    }

    /**
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime $datedebut
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }

    /**
     * @return int
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * @param int $cout
     */
    public function setCout($cout)
    {
        $this->cout = $cout;
    }

    /**
     * @return string
     */
    public function getImagec()
    {
        return $this->imagec;
    }

    /**
     * @param string $imagec
     */
    public function setImagec($imagec)
    {
        $this->imagec = $imagec;
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
        return null === $this->imageC
            ? null
            : $this->getUploadRootDir().'/'.$this->imageC;
    }

    public function getWebImage()
    {
        return null === $this->imageC
            ? null
            : $this->getUploadDir().'/'.$this->imageC;
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
        $this->imagec = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    private $participe ;

    /**
     * @return mixed
     */
    public function getParticipe()
    {
        return $this->participe;
    }

    /**
     * @param mixed $participe
     */
    public function setParticipe($participe)
    {
        $this->participe = $participe;
    }




}


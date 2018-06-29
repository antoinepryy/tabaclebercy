<?php

namespace JuniorISEP\VitrineBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 *@UniqueEntity("name")
 * @ORM\Entity(repositoryClass="JuniorISEP\VitrineBundle\Repository\BrandRepository")
 */
class Brand
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="dispAccessoires", type="boolean")
     */
    private $dispAccessoires;

    /**
     * @var bool
     *
     * @ORM\Column(name="dispAlcools", type="boolean")
     */
    private $dispAlcools;

    /**
     * @var bool
     *
     * @ORM\Column(name="dispCigaretteElec", type="boolean")
     */
    private $dispCigaretteElec;

    /**
     * @var bool
     *
     * @ORM\Column(name="dispTabac", type="boolean")
     */
    private $dispTabac;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="brand")
     */
    private $articles;




    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dispAccessoires.
     *
     * @param bool $dispAccessoires
     *
     * @return Brand
     */
    public function setDispAccessoires($dispAccessoires)
    {
        $this->dispAccessoires = $dispAccessoires;

        return $this;
    }

    /**
     * Get dispAccessoires.
     *
     * @return bool
     */
    public function getDispAccessoires()
    {
        return $this->dispAccessoires;
    }

    /**
     * Set dispAlcools.
     *
     * @param bool $dispAlcools
     *
     * @return Brand
     */
    public function setDispAlcools($dispAlcools)
    {
        $this->dispAlcools = $dispAlcools;

        return $this;
    }

    /**
     * Get dispAlcools.
     *
     * @return bool
     */
    public function getDispAlcools()
    {
        return $this->dispAlcools;
    }

    /**
     * Set dispCigaretteElec.
     *
     * @param bool $dispCigaretteElec
     *
     * @return Brand
     */
    public function setDispCigaretteElec($dispCigaretteElec)
    {
        $this->dispCigaretteElec = $dispCigaretteElec;

        return $this;
    }

    /**
     * Get dispCigaretteElec.
     *
     * @return bool
     */
    public function getDispCigaretteElec()
    {
        return $this->dispCigaretteElec;
    }

    /**
     * Set dispTabac.
     *
     * @param bool $dispTabac
     *
     * @return Brand
     */
    public function setDispTabac($dispTabac)
    {
        $this->dispTabac = $dispTabac;

        return $this;
    }

    /**
     * Get dispTabac.
     *
     * @return bool
     */
    public function getDispTabac()
    {
        return $this->dispTabac;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add article.
     *
     * @param \JuniorISEP\VitrineBundle\Entity\Article $article
     *
     * @return Brand
     */
    public function addArticle(\JuniorISEP\VitrineBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article.
     *
     * @param \JuniorISEP\VitrineBundle\Entity\Article $article
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeArticle(\JuniorISEP\VitrineBundle\Entity\Article $article)
    {
        return $this->articles->removeElement($article);
    }

    /**
     * Get articles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}

<?php

namespace JuniorISEP\VitrineBundle\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;


/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="JuniorISEP\VitrineBundle\Repository\ArticleRepository")
 * @Vich\Uploadable
 */
class Article
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var bool
     *
     * @ORM\Column(name="onOrder", type="boolean")
     */
    private $onOrder;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="article_images", fileNameProperty="image")
     * @var File
     *
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="articles")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="articles")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    private $section;


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
     * @return Article
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return Article
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set available.
     *
     * @param bool $available
     *
     * @return Article
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available.
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set onOrder.
     *
     * @param bool $onOrder
     *
     * @return Article
     */
    public function setOnOrder($onOrder)
    {
        $this->onOrder = $onOrder;

        return $this;
    }

    /**
     * Get onOrder.
     *
     * @return bool
     */
    public function getOnOrder()
    {
        return $this->onOrder;
    }


    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setPictureFile(File $image = null)
    {
        $this->pictureFile = $image;
        if (null !== $image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setUpdatedAt(){
      $this->updatedAt = new \DateTime('now');
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set brand.
     *
     * @param \JuniorISEP\VitrineBundle\Entity\Brand|null $brand
     *
     * @return Article
     */
    public function setBrand(\JuniorISEP\VitrineBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return \JuniorISEP\VitrineBundle\Entity\Brand|null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set section.
     *
     * @param \JuniorISEP\VitrineBundle\Entity\Section|null $section
     *
     * @return Article
     */
    public function setSection(\JuniorISEP\VitrineBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section.
     *
     * @return \JuniorISEP\VitrineBundle\Entity\Section|null
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Get brandfirstletter.
     *
     * @return string|null
     */
    public function getBrandFirstLetter()
    {
        $brand = $this->getBrand();
        $brandName = $brand->getName();
        $brandFirstLetter = $brandName[0];

        return $brandFirstLetter;
    }


}

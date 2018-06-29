<?php

namespace JuniorISEP\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Access
 *
 * @ORM\Table(name="access")
 * @ORM\Entity(repositoryClass="JuniorISEP\VitrineBundle\Repository\AccessRepository")
 */
class Access
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
     * @var bool
     *
     * @ORM\Column(name="tabac", type="boolean")
     */
    private $tabac;

    /**
     * @var bool
     *
     * @ORM\Column(name="accessoires", type="boolean")
     */
    private $accessoires;

    /**
     * @var bool
     *
     * @ORM\Column(name="cigaretteElec", type="boolean")
     */
    private $cigaretteElec;

    /**
     * @var bool
     *
     * @ORM\Column(name="alcools", type="boolean")
     */
    private $alcools;


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
     * Set tabac.
     *
     * @param bool $tabac
     *
     * @return Access
     */
    public function setTabac($tabac)
    {
        $this->tabac = $tabac;

        return $this;
    }

    /**
     * Get tabac.
     *
     * @return bool
     */
    public function getTabac()
    {
        return $this->tabac;
    }

    /**
     * Set accessoires.
     *
     * @param bool $accessoires
     *
     * @return Access
     */
    public function setAccessoires($accessoires)
    {
        $this->accessoires = $accessoires;

        return $this;
    }

    /**
     * Get accessoires.
     *
     * @return bool
     */
    public function getAccessoires()
    {
        return $this->accessoires;
    }

    /**
     * Set cigaretteElec.
     *
     * @param bool $cigaretteElec
     *
     * @return Access
     */
    public function setCigaretteElec($cigaretteElec)
    {
        $this->cigaretteElec = $cigaretteElec;

        return $this;
    }

    /**
     * Get cigaretteElec.
     *
     * @return bool
     */
    public function getCigaretteElec()
    {
        return $this->cigaretteElec;
    }

    /**
     * Set alcools.
     *
     * @param bool $alcools
     *
     * @return Access
     */
    public function setAlcools($alcools)
    {
        $this->alcools = $alcools;

        return $this;
    }

    /**
     * Get alcools.
     *
     * @return bool
     */
    public function getAlcools()
    {
        return $this->alcools;
    }
}

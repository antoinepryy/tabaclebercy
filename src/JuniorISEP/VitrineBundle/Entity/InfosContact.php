<?php

namespace JuniorISEP\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfosContact
 *
 * @ORM\Table(name="infos_contact")
 * @ORM\Entity(repositoryClass="JuniorISEP\VitrineBundle\Repository\InfosContactRepository")
 */
class InfosContact
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
     * @var string|null
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

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
     * Set text.
     *
     * @param string|null $text
     *
     * @return InfosContact
     */
    public function setText($text = null)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }
}

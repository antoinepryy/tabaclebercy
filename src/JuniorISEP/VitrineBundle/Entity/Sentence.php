<?php

namespace JuniorISEP\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sentence
 *
 * @ORM\Table(name="sentence")
 * @ORM\Entity(repositoryClass="JuniorISEP\VitrineBundle\Repository\SentenceRepository")
 */
class Sentence
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
     * @ORM\Column(name="sentence", type="text", nullable=true)
     */
    private $sentence;


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
     * Set sentence.
     *
     * @param string|null $sentence
     *
     * @return Sentence
     */
    public function setSentence($sentence = null)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get sentence.
     *
     * @return string|null
     */
    public function getSentence()
    {
        return $this->sentence;
    }
}

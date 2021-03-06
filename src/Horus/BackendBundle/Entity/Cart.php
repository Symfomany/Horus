<?php

namespace Horus\BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations


/**
 * Produit
 * @ORM\Entity(repositoryClass="Horus\BackendBundle\Repository\CommandesProduitRepository")
 * @ORM\Table(name="cart")
 * @ORM\HasLifecycleCallbacks()
 */
class Cart
{

    /**
     * Constructor
     */
    public function __construct(){
        $this->dateCreated = new \Datetime('now');
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;


    /**
     * @ORM\OneToOne(targetEntity="Client", inversedBy="cart")
     * @ORM\JoinColumn(name="clients_id", referencedColumnName="id")
     */
    private $client;


    /**
     * @var integer
     * @ORM\Column(name="totalTTC", type="float", nullable=false)
     */
    private $totalTTC;

    /**
     * @var integer
     * @ORM\Column(name="totalHT", type="float", nullable=false)
     */
    private $totalHT;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreated
     *
     * @param datetime $dateCreated
     * @return Cart
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return datetime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set totalTTC
     *
     * @param float $totalTTC
     * @return Cart
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;
        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return float 
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * Set totalHT
     *
     * @param float $totalHT
     * @return Cart
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;
        return $this;
    }

    /**
     * Get totalHT
     *
     * @return float 
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * Set client
     *
     * @param Horus\BackendBundle\Entity\Client $client
     * @return Cart
     */
    public function setClient(\Horus\BackendBundle\Entity\Client $client = null)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get client
     *
     * @return Horus\BackendBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set content
     *
     * @param text $content
     * @return Cart
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }
}
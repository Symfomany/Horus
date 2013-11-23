<?php

namespace Horus\SiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations


/**
 * Transports
 * @ORM\Entity(repositoryClass="Horus\SiteBundle\Repository\TransportRepository")
 * @ORM\Table(name="transport")
 * @ORM\HasLifecycleCallbacks()
 */
class Transports
{


    /**
     * Constructor
     */
    public function __construct(){
        $this->dateCreated = new \Datetime('now');
        $this->dateUpdated = new \Datetime('now');
        $this->isVisible = true;
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
     * @Assert\Url(message="Votre URL de Vidéo n'est pas valide")
     * @Assert\Length(
     *      min = "8",
     *      max = "1000",
     *      minMessage = "Votre video doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre video ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="video", type="string", length=200, nullable=false)
     */
    private $video;

    /**
     * @Assert\Length(
     *      min = "8",
     *      max = "1000",
     *      minMessage = "Votre service doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre service ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="service", type="text", nullable=false)
     */
    private $service;

    /**
     * @ORM\OneToOne(targetEntity="Villes")
     * @ORM\JoinColumn(name="villes_id", referencedColumnName="id")
     */
    private $ville;

    /**
     * @ORM\OneToOne(targetEntity="Departements")
     * @ORM\JoinColumn(name="departements_id", referencedColumnName="id")
     */
    private $departement;


    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;


    /**
     * @Assert\NotBlank(
     *     message = "Le prix TTC ne doit pas etre vide"
     * )
     * @Assert\Regex(pattern="/[0-9]{1,}[.,]{0,1}[0-9]{0,2}/", message="Le prix TTC n'est pas valide")
     * @ORM\Column(name="prix", type="float", nullable=false)
     */
    private $prix;


    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="nature", type="integer", nullable=false)
     */
    private $nature;


    /**
     * @Assert\NotBlank(
     *     message = "Le titre ne doit pas etre vide"
     * )
     * @Assert\Length(
     *      min = "5",
     *      max = "1000",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="title", type="string", length=200, nullable=true)
     */
    private $title;


    /**
     * @Assert\NotBlank(
     *     message = "La description ne doit pas etre vide"
     * )
     * @Assert\Length(
     *      min = "5",
     *      max = "3000",
     *      minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre description ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(name="isVisible", type="boolean", nullable=true)
     */
    private $isVisible;

    /**
     * @var string
     * @ORM\Column(name="livraison", type="integer", nullable=true)
     */
    private $livraison;

    /**
     * @var string
     * @ORM\Column(name="from", type="float", nullable=true)
     */
    private $from;

    /**
     * @var string
     * @ORM\Column(name="to", type="float", nullable=true)
     */
    private $to;

    /**
     * @var string
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @ORM\Column(name="quantity", type="string", nullable=true)
     */
    private $quantity;

    /**
     * @var string
     * @ORM\Column(name="tva", type="float", nullable=true)
     */
    private $tva;

    /**
     * @var string
     * @Assert\Regex(pattern="/[0-9]{1,}[.,]{0,1}[0-9]{0,2}/", message="Le prix TTC n'est pas valide")
     * @ORM\Column(name="poid", type="float", nullable=true)
     */
    private $poid;

    /**
     * @var string
     * @ORM\Column(name="longueur", type="float", nullable=true)
     */
    private $longueur;

    /**
     * @var string
     * @ORM\Column(name="largeur", type="float", nullable=true)
     */
    private $largeur;

    /**
     * @var string
     * @ORM\Column(name="hauteur", type="float", nullable=true)
     */
    private $hauteur;

    /**
     * @var string
     * @ORM\Column(name="profondeur", type="float", nullable=true)
     */
    private $profondeur;


    /**
     * @var string
     * @ORM\Column(name="delay", type="float", nullable=true)
     */
    private $delay;


    /**
     * @var string
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    private $url;


    /**
     * @var string
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", nullable=true)
     */
    private $picture;

    /**
     * @var string
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="produits")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;


    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="articless")
     * @ORM\JoinTable(name="produit_category")
     */
    private $cates;

    /**
     * @var integer
     * @ORM\Column(name="point", type="integer", nullable=true)
     */
    private $point;



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
     * Set video
     *
     * @param string $video
     * @return Transports
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set service
     *
     * @param text $service
     * @return Transports
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * Get service
     *
     * @return text 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Transports
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set prix
     *
     * @param float $prix
     * @return Transports
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     * @return Transports
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * Get etat
     *
     * @return integer 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set nature
     *
     * @param integer $nature
     * @return Transports
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
        return $this;
    }

    /**
     * Get nature
     *
     * @return integer 
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Transports
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param text $content
     * @return Transports
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

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     * @return Transports
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean 
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Set livraison
     *
     * @param integer $livraison
     * @return Transports
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;
        return $this;
    }

    /**
     * Get livraison
     *
     * @return integer 
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * Set from
     *
     * @param float $from
     * @return Transports
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Get from
     *
     * @return float 
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param float $to
     * @return Transports
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Get to
     *
     * @return float 
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return Transports
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Get quantity
     *
     * @return string 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return Transports
     */
    public function setTva($tva)
    {
        $this->tva = $tva;
        return $this;
    }

    /**
     * Get tva
     *
     * @return float 
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set poid
     *
     * @param float $poid
     * @return Transports
     */
    public function setPoid($poid)
    {
        $this->poid = $poid;
        return $this;
    }

    /**
     * Get poid
     *
     * @return float 
     */
    public function getPoid()
    {
        return $this->poid;
    }

    /**
     * Set longueur
     *
     * @param float $longueur
     * @return Transports
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
        return $this;
    }

    /**
     * Get longueur
     *
     * @return float 
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * Set largeur
     *
     * @param float $largeur
     * @return Transports
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
        return $this;
    }

    /**
     * Get largeur
     *
     * @return float 
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set hauteur
     *
     * @param float $hauteur
     * @return Transports
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;
        return $this;
    }

    /**
     * Get hauteur
     *
     * @return float 
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }

    /**
     * Set profondeur
     *
     * @param float $profondeur
     * @return Transports
     */
    public function setProfondeur($profondeur)
    {
        $this->profondeur = $profondeur;
        return $this;
    }

    /**
     * Get profondeur
     *
     * @return float 
     */
    public function getProfondeur()
    {
        return $this->profondeur;
    }

    /**
     * Set dateCreated
     *
     * @param datetime $dateCreated
     * @return Transports
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
     * Set dateUpdated
     *
     * @param datetime $dateUpdated
     * @return Transports
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return datetime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set point
     *
     * @param integer $point
     * @return Transports
     */
    public function setPoint($point)
    {
        $this->point = $point;
        return $this;
    }

    /**
     * Get point
     *
     * @return integer 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set category
     *
     * @param Horus\SiteBundle\Entity\Category $category
     * @return Transports
     */
    public function setCategory(\Horus\SiteBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return Horus\SiteBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add cates
     *
     * @param Horus\SiteBundle\Entity\Category $cates
     * @return Transports
     */
    public function addCate(\Horus\SiteBundle\Entity\Category $cates)
    {
        $this->cates[] = $cates;
        return $this;
    }

    /**
     * Remove cates
     *
     * @param Horus\SiteBundle\Entity\Category $cates
     */
    public function removeCate(\Horus\SiteBundle\Entity\Category $cates)
    {
        $this->cates->removeElement($cates);
    }

    /**
     * Get cates
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCates()
    {
        return $this->cates;
    }

    /**
     * Set delay
     *
     * @param float $delay
     * @return Transports
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
        return $this;
    }

    /**
     * Get delay
     *
     * @return float 
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Transports
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set ville
     *
     * @param Horus\SiteBundle\Entity\Villes $ville
     * @return Transports
     */
    public function setVille(\Horus\SiteBundle\Entity\Villes $ville = null)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * Get ville
     *
     * @return Horus\SiteBundle\Entity\Villes 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set departement
     *
     * @param Horus\SiteBundle\Entity\Departements $departement
     * @return Transports
     */
    public function setDepartement(\Horus\SiteBundle\Entity\Departements $departement = null)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * Get departement
     *
     * @return Horus\SiteBundle\Entity\Departements 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Transports
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
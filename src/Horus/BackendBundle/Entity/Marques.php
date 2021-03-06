<?php

namespace Horus\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Horus\BackendBundle\Util\Box;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Class Marques
 * @ORM\Table(name="marques")
 * @ORM\Entity(repositoryClass="Horus\BackendBundle\Repository\MarquesRepository")
 * @Gedmo\Tree(type="nested")
 * @ORM\HasLifecycleCallbacks()
 */
class Marques
{

    public function __construct()
    {
        $this->dateCreated = new \Datetime('now');
        $this->dateUpdated = new \Datetime('now');
        $this->active = true;
    }

    /* ***********************************************  OTHERS  *************************************************** */

    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=32)
     * @Assert\NotBlank(message = "Votre titre ne peut être vite")
     * @Assert\Length(
     *      min = "3",
     *      max = "600",
     *      minMessage = "Votre titre doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Votre titre doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $title;

    /**
     * @var string $title
     *
     * @ORM\Column(name="keywords", type="string", length=32)
     * @Assert\Length(
     *      min = "4",
     *      max = "600",
     *      minMessage = "Vos mots-clefs doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Vos mots-clefs doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $keywords;

    /**
     * @var string $resume
     *
     * @ORM\Column(name="resume", type="string", length=32)
     * @Assert\NotBlank(message = "Votre resume ne peut être vite")
     * @Assert\Length(
     *      min = "5",
     *      max = "7000",
     *      minMessage = "Votre resume doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Votre resume doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $resume;

    /**
     * @var string $resume
     *
     * @ORM\Column(name="description", type="string", length=32)
     * @Assert\NotBlank(message = "Votre description ne peut être vite")
     * @Assert\Length(
     *      min = "5",
     *      max = "10000",
     *      minMessage = "Votre description doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Votre description doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $description;


    /**
     * @var string $url
     * @ORM\Column(name="url", type="string", length=32)
     * @Assert\Url( message = "Votre URL est invalide")
     */
    protected $url;

    /**
     * @var string $picture
     * @ORM\Column(name="picture", type="string", length=32)
     */
    protected $path;

    /**
     * @var string $metaTitle
     *
     * @ORM\Column(name="meta_title", type="text")
     * @Assert\Length(
     *      min = "2",
     *      max = "600",
     *      minMessage = "Votre Meta Title doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Votre Meta Title doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $metaTitle;

    /**
     * @var string $metaDescription
     *
     * @ORM\Column(name="meta_description", type="text")
     * @Assert\Length(
     *      min = "2",
     *      max = "600",
     *      minMessage = "Votre Meta Description doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Votre Meta Description doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $metaDescription;

    /**
     * @var string $metaKeywords
     *
     * @ORM\Column(name="meta_keywords", type="text")
     * @Assert\Length(
     *      min = "2",
     *      max = "600",
     *      minMessage = "Votre Meta Keywords doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Votre Meta Keywords doit faire au maximum {{ limit }} caractères"
     *  )
     */
    protected $metaKeywords;

    /**
     * @var string $active
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @var string $dateCreated
     * @ORM\Column(name="date_created", type="datetime")
     */
    protected $dateCreated;

    /**
     * @var string $dateUpdated
     * @ORM\Column(name="date_updated", type="datetime")
     */
    protected $dateUpdated;

    /**
     * @Assert\Image(
     *     minWidth = 200,
     *     minHeight  = 200,
     *     maxWidth = 3000,
     *     maxHeight = 3000,
     *     maxSize = "6000k",
     *     mimeTypes = {"image/jpg","image/jpeg", "image/png", "image/gif", "image/bmp"},
     *     mimeTypesMessage = "Image au format non supporté",
     *    maxWidthMessage = "Image trop grande en largeur {{ width }}px. Le maximum en largeur est de {{ max_width }}px" ,
     *    minWidthMessage = "Image trop petite en largeur {{ width }}px. Le minimum en largeur est de {{ min_width }}px" ,
     *    minHeightMessage = "Image trop petite en hauteur {{ height }}px. Le mimum en hauteur est de {{ min_height }}px" ,
     *    maxHeightMessage = "Image trop grande en hauteur  {{ height }}px. Le maximum en hauteur est de {{ max_height }}px"
     * )
     */
    public $file;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Marques", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Marques", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="marque")
     */
    private $marques;

    /**
     * @ORM\OneToMany(targetEntity="ImageMarques", mappedBy="marque", cascade={"all"},orphanRemoval=true)
     * @ORM\OrderBy({"dateCreated" = "DESC"})
     */
    protected $images;


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload($id = null)
    {

        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        if(!is_dir(@mkdir($this->getUploadRootDir().'/'.$id)))
            @mkdir($this->getUploadRootDir().'/'.$id);


        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé

        $rewritename = sha1(uniqid(mt_rand(), true));
        $rewritefile = $rewritename.'.'.$this->file->guessExtension();
        $extension = $this->file->guessExtension();

        $this->file->move($this->getUploadRootDir().'/'.$id, $rewritefile);

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->path = $rewritefile;

//        $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();

        //Original photo
        $bigfile = $this->getUploadRootDir().'/'.$id.'/'.$rewritefile;

        if ($extension == "jpg" || $extension == "jpeg") {
            $src_img = imagecreatefromjpeg($bigfile);
        }
        if ($extension == "png") {
            $src_img = imagecreatefrompng($bigfile);
        }
        if ($extension == "gif") {
            $src_img = imagecreatefromgif($bigfile);
        }

        // Le ratio de l'image uploadée
        $oldWidth = imageSX($src_img);
        $oldHeight = imageSY($src_img);
        $ratio = $oldWidth / $oldHeight;

        $taille = array(
            array(
                'name' => 'big',
                'width' => 500,
                'height' => 300
            ),
            array(
                'name' => 'medium',
                'width' => 300,
                'height' => 260
            ),
            array(
                'name' => 'small',
                'width' => 250,
                'height' => 180
            ),
        );

        // C'est parti
        foreach ($taille as $value) {

            // On prépare les valeurs
            $width = $value['width'] - 1;
            $height = $value['height'] -1;
            $ratioImg = $width / $height;

            // On calcule les nouvelles
            if ($ratioImg > $ratio) {
                $newWidth = $width;
                $newHeight = $width / $ratio;
            } elseif ($ratioImg < $ratio) {
                $newHeight = $height;
                $newWidth = $height * $ratio;
            } else {
                $newWidth = $width;
                $newHeight = $height;
            }

            // Point de départ du crop
            $x = ($newWidth - $width) / 2;
            $y = 0;

            // On bosse sur l'image
            $imagine = new \Imagine\Gd\Imagine();
            $imagine
                ->open($bigfile)
                ->thumbnail(new \Imagine\Image\Box($newWidth, $newHeight))
                ->save(
                    $this->getUploadRootDir().'/'.$id.'/' . $rewritename . '-' . $value['name'] . '.' . $extension,
                    array(
                        'quality' => 80
                    )
                );
        }

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/marques';
    }


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
     * Set title
     *
     * @param string $title
     * @return Marques
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
     * Set resume
     *
     * @param string $resume
     * @return Marques
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        if(!empty($this->resume))
            return $this->resume;
        else
            return Box::limit_words($this->description);
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Marques
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Marques
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set metaTitle
     *
     * @param text $metaTitle
     * @return Marques
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return text 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param text $metaDescription
     * @return Marques
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return text 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param text $metaKeywords
     * @return Marques
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return text 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Marques
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateCreated
     *
     * @param datetime $dateCreated
     * @return Marques
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
     * @return Marques
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
     * Set lft
     *
     * @param integer $lft
     * @return Marques
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Marques
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Marques
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Marques
     */
    public function setRoot($root)
    {
        $this->root = $root;
        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param Horus\BackendBundle\Entity\Marques $parent
     * @return Marques
     */
    public function setParent(\Horus\BackendBundle\Entity\Marques $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get parent
     *
     * @return Horus\BackendBundle\Entity\Marques
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Horus\BackendBundle\Entity\Marques $children
     * @return Marques
     */
    public function addChildren(\Horus\BackendBundle\Entity\Marques $children)
    {
        $this->children[] = $children;
        return $this;
    }

    /**
     * Remove children
     *
     * @param Horus\BackendBundle\Entity\Marques $children
     */
    public function removeChildren(\Horus\BackendBundle\Entity\Marques $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add images
     *
     * @param Horus\BackendBundle\Entity\ImageMarques $images
     * @return Marques
     */
    public function addImage(\Horus\BackendBundle\Entity\ImageMarques $images)
    {
        $this->images[] = $images;
        return $this;
    }

    /**
     * Remove images
     *
     * @param Horus\BackendBundle\Entity\ImageMarques $images
     */
    public function removeImage(\Horus\BackendBundle\Entity\ImageMarques $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add marques
     *
     * @param Horus\BackendBundle\Entity\Marques $marques
     * @return Marques
     */
    public function addMarque(\Horus\BackendBundle\Entity\Marques $marques)
    {
        $this->marques[] = $marques;
        return $this;
    }

    /**
     * Remove marques
     *
     * @param Horus\BackendBundle\Entity\Marques $marques
     */
    public function removeMarque(\Horus\BackendBundle\Entity\Marques $marques)
    {
        $this->marques->removeElement($marques);
    }

    /**
     * Get marques
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMarques()
    {
        return $this->marques;
    }

    /**
     * Get Title
     * @return string
     */
    public function __toString(){
        return Box::limit_words($this->getTitle());
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Marques
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }



    public function getOptionLabel()
    {
        return str_repeat(
            html_entity_decode('...', ENT_QUOTES, 'UTF-8'),
            ($this->getLvl() + 1) * 2
        ) . $this->getTitle();
    }


    /**
     * Set url
     *
     * @param string $url
     * @return Marques
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
}
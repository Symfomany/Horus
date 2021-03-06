<?php

namespace Horus\BackendBundle\Listener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Horus\BackendBundle\Document\Notifications;
use Horus\BackendBundle\Entity\Produits;
use Doctrine\ODM\MongoDB\DocumentManager;


/**
 * Class CategoryListener
 * @package Horus\BackendBundle\Listener
 */
class CategoryListener
{

    /**
     * @var object
     */
    protected $dm;


    /**
     * @param SecurityContext $context
     * @param Doctrine $doctrine
     * @param ContainerInterface $container
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }


    /**
     * After each persist
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {

        $entityManager = $args->getEntityManager();

        $productquantity = $entityManager->getRepository('HorusBackendBundle:Produit')->getProductsIsQuantityNull();
        $token = sha1("1"."q".date('m/Y'));
        $notification = $this->dm->getRepository('HorusBackendBundle:Notifications')->findOneByToken($token);

        if((int)$productquantity > 0){

            if(!$notification){
                $notification = new Notifications();
                $notification->setContent('Il y a '.$productquantity.' produits dont la quantité <= 3');
                $notification->setTitre('Quantité de produit');
                $notification->setNature(1);
                $notification->setToken($token);
                $this->dm->persist($notification);
                $this->dm->flush();
            }
        }else{
            if($notification){
                $this->dm->remove($notification);
                $this->dm->flush();
            }
        }



        $productdesactivate = $entityManager->getRepository('HorusBackendBundle:Produit')->getProductsIsDesactive();
        $token = sha1("1"."d".date('m/Y'));
        $notification = $this->dm->getRepository('HorusBackendBundle:Notifications')->findOneByToken($token);

        if((int)$productdesactivate > 0){

            if(!$notification){
                $notification = new Notifications();
                $notification->setContent('Il y a '.$productdesactivate.' produits désactivés');
                $notification->setTitre('Produit inactifs');
                $notification->setNature(1);
                $notification->setToken($token);
                $this->dm->persist($notification);
                $this->dm->flush();
            }
        }else{
            if($notification){
                $this->dm->remove($notification);
                $this->dm->flush();
            }
        }

    }
}

?>

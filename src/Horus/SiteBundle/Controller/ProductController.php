<?php

namespace Horus\SiteBundle\Controller;

use fg\Essence\Essence;
use Horus\SiteBundle\Entity\Image;
use Horus\SiteBundle\Entity\Liens;
use Horus\SiteBundle\Entity\Meta;
use Horus\SiteBundle\Entity\Pj;
use Horus\SiteBundle\Entity\Produit;

use Horus\SiteBundle\Entity\Seo;
use Horus\SiteBundle\Form\ImageType;
use Horus\SiteBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductController
 * @package Horus\SiteBundle\Controller
 */
class ProductController extends Controller
{

    /**
     * All action commercial
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function commercialsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commercials = $em->getRepository('HorusSiteBundle:Commercial')->findAll();

        return $this->render('HorusSiteBundle:Commercial:commercials.html.twig', array('commercials' => $commercials));
    }

    /**
     * All Products
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('HorusSiteBundle:Produit')->findAll();
        $paginate_by_page = $this->container->getParameter('paginate_by_page');

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $this->get('request')->query->get('page', 1) /*page number*/,
            $paginate_by_page
        );

        return $this->render('HorusSiteBundle:Product:products.html.twig', array('produits' => $pagination));
    }

    /**
     * Remove a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeproductAction(Produit $id)
    {
        $em = $this->getDoctrine()->getManager();

        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "Le produit ".$id->getTitle()." vient d'être supprimé"
        );

        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "Le produit a été supprimé"
        );


        
        return $this->redirect($this->generateUrl('horus_site_products'));
    }

    /**
     * Remove image of product
     * @param Image $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeimageproductAction(Image $id)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'image du produit a été activé"
        );

        return $this->redirect($this->generateUrl('horus_site_edit_pictures_product', array('id' => $id->getProduit()->getId())));
    }

    /**
     * Cover image of product
     * @param Image $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function coverimageproductAction(Image $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $id->getProduit();

        /**
         * Handle Old Images
         */
        $oldsimage = $product->getImages();
        if (!empty($oldsimage))
            foreach ($oldsimage as $img) {
                $img->setCover(false);
                $em->persist($img);
                $em->flush();
            }
        $id->setCover(true);
        $em->persist($id);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            "L'image du produit a été mise en avant"
        );

        return $this->redirect($this->generateUrl('horus_site_edit_pictures_product', array('id' => $id->getProduit()->getId())));
    }

    /**
     * Add picture of product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function pictureproductAction(Produit $id)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $image = new Image();
        $image->setProduit($id);
        $form = $this->createForm(new ImageType(), $image);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $isfirst = $em->getRepository('HorusSiteBundle:Image')->isFirstImage($id);
            if ((int)$isfirst['nombre'] == 0)
                $image->setCover(true);

            $image->upload($id->getId());
            $em->persist($image);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "L'image a été ajouté"
            );
            return new JsonResponse(true);
        }

        return $this->render('HorusSiteBundle:Product:pictureproduct.html.twig',
            array(
                'form' => $form->createView(),
                'produit' => $id,
            )
        );
    }


    /**
     * See a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seeproductAction(Produit $id)
    {
        return $this->render('HorusSiteBundle:Product:visualizeproduct.html.twig',
            array(
                'produit' => $id,
            )
        );
    }


    /**
     * See a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addquantityproductAction(Produit $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setQuantity($id->getQuantity() + 1);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La quantité du produit a bien été augmentée"
        );

        return $this->redirect($this->generateUrl('horus_site_products'));
    }


    /**
     * See a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removequantityproductAction(Produit $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setQuantity($id->getQuantity() - 1);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "La quantité du produit a bien été diminuée"
        );

        return $this->redirect($this->generateUrl('horus_site_products'));
    }

    /**
     * Desactive a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desactiveproductAction(Produit $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setIsVisible(false);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "Le produit a été désactivé"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "Le produit ".$id->getTitle()." a été desactivé"
        );


        return $this->redirect($this->generateUrl('horus_site_products'));
    }

    /**
     * Active a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activeproductAction(Produit $id)
    {
        $em = $this->getDoctrine()->getManager();

        $id->setIsVisible(true);
        $em->persist($id);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            "Le produit a été activé"
        );
        $this->get('session')->getFlashBag()->add(
            'messagerealtime',
            "Le produit ".$id->getTitle()." a été activé"
        );

        return $this->redirect($this->generateUrl('horus_site_products'));
    }

    /**
     * Create a product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createproductAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('HorusSiteBundle:Category')->isCategory();
        if ((int)$category['nombre'] == 0) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                "Avant de gérer le produit, vous devez créer une catégorie"
            );
            return $this->redirect($this->generateUrl('horus_site_add_category'));
        }

        $meta = new Meta();
        $lien = new Liens();
        $pj = new Pj();
        $produit = new Produit();
        $seo = new Seo();
        $produit->addSeo($seo);
        $produit->addMeta($meta);
        $produit->addLien($lien);
        $produit->addPj($pj);
        $seo->setProduit($produit);
        $meta->setProduit($produit);
        $lien->setProduit($produit);
        $pj->setProduit($produit);

        $form = $this->createForm(new ProductType(), $produit);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $pj->upload($produit->getId());
            $em->persist($pj);
            $em->persist($produit);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "Le produit a été crée"
            );
            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "Le produit ".$produit->getTitle()." vient d'être crée"
            );
            return $this->redirect($this->generateUrl('horus_site_edit_pictures_product', array('id' => $produit->getId())));
        }

        return $this->render('HorusSiteBundle:Product:createproduct.html.twig',
            array(
                'form' => $form->createView(),
            )
        );

    }


    /**
     * Edit a product
     * @param Produit $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editproductAction(Produit $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ProductType($id), $id);
        $form->handleRequest($request);

        $category = $em->getRepository('HorusSiteBundle:Category')->isCategory();
        if ((int)$category['nombre'] == 0) {
            $this->get('session')->getFlashBag()->add(
                'warning',
                "Avant de gérer le produit, vous devez créer une catégorie"
            );
            return $this->redirect($this->generateUrl('horus_site_add_category'));
        }

        $Essence = new \fg\Essence\Essence();
        $media = $Essence->embed($id->getVideo(), array(
            'maxwidth' => 400,
            'maxheight' => 200
        ));


        if ($form->isValid()) {
            $pjs = $id->getPjs();
            if (!empty($pjs))
                foreach ($pjs as $pj) {
                    $pj->upload($id->getId());
                    $pj->setProduit($id);
                }

            $liens = $id->getLiens();
            if (!empty($liens))
                foreach ($liens as $lien) {
                    $lien->setProduit($id);
                }

            $id->setDateUpdated(new \Datetime('now'));
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "Le produit a été edité"
            );

            $this->get('session')->getFlashBag()->add(
                'messagerealtime',
                "Le produit ".$id->getTitle()." vient d'être modifié"
            );
            return $this->redirect($this->generateUrl('horus_site_products'));
        }

        return $this->render('HorusSiteBundle:Product:editproduct.html.twig',
            array(
                'form' => $form->createView(),
                'produit' => $id,
                'video' => $media,
            )
        );
    }


}

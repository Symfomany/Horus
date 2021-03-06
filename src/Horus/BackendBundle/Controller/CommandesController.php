<?php

namespace Horus\BackendBundle\Controller;

use Horus\BackendBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Horus\BackendBundle\Entity\Commandes;


/**
 * Class CommandesController
 * @package Horus\BackendBundle\Controller
 */
class CommandesController extends Controller
{
    public function commandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('HorusBackendBundle:Commandes')->findAll();

        $display = $this->container->get('request')->get('display', 5);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $commandes,
            $this->get('request')->query->get('page', 1) /*page number*/,
            $display
        );

        return $this->render('HorusBackendBundle:Commandes:commandes.html.twig', array('commandes' => $pagination));
    }
   public function lastcommandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('HorusBackendBundle:Commandes')->findAll(array(), array('dateCreated' => 'DESC'),7);

        return $this->render('HorusBackendBundle:Commandes:lastcommandes.html.twig', array('commandes' => $commandes));
    }

    public function commandeAction(Commandes $id)
    {

        return $this->render('HorusBackendBundle:Commandes:commande.html.twig', array('commande' => $id));
    }

    public function editcommandeAction(Commandes $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CommandeType(), $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($id);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "La commande a été ajouté"
            );

            /**
             * Notifications
             */
            $this->container->get('lastactions_listener')->insertActions('Edition', 'a édité une commande','glyphicon glyphicon-pencil');


            return $this->redirect($this->generateUrl('horus_site_commandes'));
        }

        return $this->render('HorusBackendBundle:Commandes:editcommande.html.twig', array('commande' => $id, 'form' => $form->createView()));
    }

    public function generatefactureAction(Commandes $id)
    {
        $pdfObj = $this->container->get("white_october.tcpdf")->create();

        // set document information
        $pdfObj->SetCreator(PDF_CREATOR);
        $pdfObj->SetAuthor('Horus CMF');
        $pdfObj->SetTitle('Commande '.$id->getReference());
        $pdfObj->SetSubject('Commande');
        $pdfObj->SetKeywords('Commande, Horus CMF');

// set default header data
        $pdfObj->SetHeaderData(null, null, 'Horus CMF Commande ' . $id->getReference(), 'Horus CMF Commande '. $id->getReference(), array(0, 64, 255), array(0, 64, 128));
        $pdfObj->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
        $pdfObj->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdfObj->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdfObj->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdfObj->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdfObj->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdfObj->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdfObj->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdfObj->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set default font subsetting mode
        $pdfObj->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdfObj->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdfObj->AddPage();

// set text shadow effect
        $pdfObj->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
        $html = $this->renderView('HorusBackendBundle:Commandes:commande.pdf.twig', array('commande' => $id));

//        var_dump($html);
//        exit();
// Print text using writeHTMLCell()
        $pdfObj->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $path = $this->get('kernel')->getRootDir() . '/../web';

        $pdfObj->Output('horus_cmf.pdf', 'I');
        exit('Commande téléchargée');

        return $this->render('HorusBackendBundle:Commandes:commande.html.twig', array('commande' => $id));
    }
}

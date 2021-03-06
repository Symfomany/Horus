<?php

namespace Horus\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommercialType
 * @package Horus\BackendBundle\Form
 */
class ConfigurationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('attr' => array('placeholder' => "Nom")))
            ->add('etat')
            ->add('name', 'text', array('required' => true,'attr' => array('placeholder' => "Nom de la boutique")))
            ->add('horaires', 'text', array('required' => false, 'attr' => array('placeholder' => "Horaires de disponibilités")))
            ->add('siret', 'text', array('required' => false, 'attr' => array('placeholder' => "SIRET")))
            ->add('prenom', 'text', array('attr' => array('placeholder' => "Prénom")))
            ->add('ville', 'text', array('required' => false,'attr' => array('placeholder' => "Ville")))
            ->add('adresse', 'text', array('required' => false,'attr' => array('placeholder' => "Adresse")))
            ->add('zipcode', 'text', array('required' => false,'attr' => array('placeholder' => "Code postal")))
            ->add('tel', 'text', array('required' => false,'attr' => array('placeholder' => "Téléphone")))
            ->add('description', 'textarea', array('attr' => array("class" => "ckeditor", 'placeholder' => 'Description complète')))
            ->add('email', 'text', array('attr' => array('placeholder' => "Email")))
            ->add('background', 'text', array('required' => false,'attr' => array('class' => 'colorpicker form-control','placeholder' => "Couleur de fond")))
            ->add('color', 'text', array('required' => false,'attr' => array('class' => 'colorpicker form-control','placeholder' => "Couleur des textes")))
            ->add('title', 'text', array('required' => false,'attr' => array('class' => 'colorpicker form-control','placeholder' => "Couleurs des titres")))
            ->add('panel', 'text', array('required' => false,'attr' => array('class' => 'colorpicker form-control','placeholder' => "Couleurs des panels")))
            ->add('url', 'text', array('required' => false,'attr' => array('placeholder' => "Url")))
            ->add('nombreParPage', 'integer', array('attr' => array('placeholder' => "Nombre par page")))
            ->add('montantValide', 'integer', array('attr' => array('placeholder' => "Montant valide")))
            ->add('emballage')
            ->add('horsStock')
            ->add('quantity')
            ->add('orderBy', 'choice', array(
                'choices' => array(0 => 'Croissant', 1 => 'Décroissant'),
                'required' => true,
            ))
            ->add('jourNouveau')
            ->add('entreprise', 'text', array('attr' => array('placeholder' => "Entreprise")));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'Horus\BackendBundle\Entity\Configuration',
            'csrf_protection' => false
        ));
    }
}
